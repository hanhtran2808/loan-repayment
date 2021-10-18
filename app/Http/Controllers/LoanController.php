<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Constants\ErrorCodeConstant;
use App\Constants\LogConstant;
use App\Constants\TableConstant;
use App\Constants\ValidationConstant;
use App\Repositories\Interfaces\LoanRepositoryInterface;
use App\Utils\Common;
use App\Utils\LogHelper;
use App\Utils\ResponseHelper;
use App\Utils\ValidationHelper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    /**
     * @var object
     */
    protected $auth_user;
    /**
     * @var LoanRepositoryInterface
     */
    protected $loan_repo;

    public function __construct(
        Request $request,
        LoanRepositoryInterface $loan_repo
    )
    {
        if (!Common::isEmpty($request[CommonConstant::PARAMETER_AUTH_USER])) {
            $this->auth_user = $request[CommonConstant::PARAMETER_AUTH_USER];
        }
        $this->loan_repo = $loan_repo;
    }

    /**
     * create new loan request
     * @param Request $request
     * @return JsonResponse
     */
    public function createLoanRequest(Request $request)
    {
        try {
            $amount = $request[ValidationConstant::LOAN_AMOUNT];
            $interestRate = $request[ValidationConstant::LOAN_INTEREST_RATE];
            // check validation
            $params = [
                ValidationConstant::LOAN_AMOUNT => $amount,
                ValidationConstant::LOAN_INTEREST_RATE => $interestRate,
            ];
            // check require and validation
            $validator = [
                ValidationConstant::LOAN_AMOUNT => 'required|numeric',
                ValidationConstant::LOAN_INTEREST_RATE => 'required|numeric|min:0|max:100',
            ];
            $validation_code = ValidationHelper::getValidationCode($params, $validator);
            if ($validation_code !== ErrorCodeConstant::ERROR_CODE_IS_SUCCESS) {
                return ResponseHelper::getResponseError($validation_code);
            }
            $user = $this->auth_user;
            // create loan request
            $loanRequest = $this->loan_repo->loanRequest($user->id, $amount, $interestRate);
            if (Common::checkKeyHasObject(CommonConstant::KEY_ERROR, $loanRequest)) {
                // has error code happen
                return ResponseHelper::getResponseError($loanRequest[CommonConstant::KEY_ERROR]);
            }
            return ResponseHelper::getResponseSuccess([
                "id" => $loanRequest->id,
                "loan_no" => $loanRequest->loan_no
            ]);
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getResponseError(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }

    /**
     * update loan request
     * @param Request $request
     * @return JsonResponse
     */
    public function updateLoanRequest(Request $request)
    {
        try {
            $loanID = $request[ValidationConstant::LOAN_ID];
            $status = $request[ValidationConstant::LOAN_STATUS];
            $statusList = implode(',', CommonConstant::LOAN_STATUS_LIST);
            // check validation
            $params = [
                ValidationConstant::LOAN_ID => $loanID,
                ValidationConstant::LOAN_STATUS => $status,
            ];
            // check require and validation
            $validator = [
                ValidationConstant::LOAN_ID => 'required',
                ValidationConstant::LOAN_STATUS => ['required', 'in:' . $statusList]
            ];
            $validation_code = ValidationHelper::getValidationCode($params, $validator);
            if ($validation_code !== ErrorCodeConstant::ERROR_CODE_IS_SUCCESS) {
                return ResponseHelper::getResponseError($validation_code);
            }
            // update loan request
            $loanRequest = $this->loan_repo->updateLoanStatus($loanID, $status);
            if (Common::checkKeyHasObject(CommonConstant::KEY_ERROR, $loanRequest)) {
                // has error code happen
                return ResponseHelper::getResponseError($loanRequest[CommonConstant::KEY_ERROR]);
            }
            return ResponseHelper::getResponseSuccess();
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getResponseError(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }

    /**
     * repay loan
     * @param Request $request
     * @return JsonResponse
     */
    public function repayLoan(Request $request)
    {
        try {
            $loanID = $request[ValidationConstant::LOAN_ID];
            $amount = $request[ValidationConstant::LOAN_ORIGINAL_AMOUNT];
            $interestAmount = $request[ValidationConstant::LOAN_INTEREST_AMOUNT];
            // check validation
            $params = [
                ValidationConstant::LOAN_ID => $loanID,
                ValidationConstant::LOAN_ORIGINAL_AMOUNT => $amount,
                ValidationConstant::LOAN_INTEREST_AMOUNT => $interestAmount,
            ];
            // check require and validation
            $validator = [
                ValidationConstant::LOAN_ID => 'required',
                ValidationConstant::LOAN_ORIGINAL_AMOUNT => 'required|numeric',
                ValidationConstant::LOAN_INTEREST_AMOUNT => 'required|numeric',
            ];
            $validation_code = ValidationHelper::getValidationCode($params, $validator);
            if ($validation_code !== ErrorCodeConstant::ERROR_CODE_IS_SUCCESS) {
                return ResponseHelper::getResponseError($validation_code);
            }
            // repay loan
            $result = $this->loan_repo->repayLoan($loanID, $amount, $interestAmount);
            if (Common::checkKeyHasObject(CommonConstant::KEY_ERROR, $result)) {
                // has error code happen
                return ResponseHelper::getResponseError($result[CommonConstant::KEY_ERROR]);
            }
            return ResponseHelper::getResponseSuccess($result);
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getResponseError(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }
}
