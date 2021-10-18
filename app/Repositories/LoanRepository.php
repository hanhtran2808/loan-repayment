<?php


namespace App\Repositories;

use App\Constants\CommonConstant;
use App\Constants\ErrorCodeConstant;
use App\Models\Loan;
use App\Models\LoanRepayment;
use App\Repositories\Interfaces\LoanRepositoryInterface;
use App\Utils\Common;
use App\Utils\LogHelper;
use App\Utils\ResponseHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\DB;

class LoanRepository extends BaseRepository implements LoanRepositoryInterface
{
    public function __construct()
    {
        $this->model = new Loan();
    }

    /**
     * create loan request
     * @param $userId
     * @param $amount
     * @param $interestRate
     * @return array|\Illuminate\Database\Eloquent\Model
     */
    public function loanRequest($userId, $amount, $interestRate)
    {
        try {
            /**
             * create loan request base on business
             * some business allow to create loan request without user who has not repay completely yet (1)
             * some business require user must repay done to continue create loan request (2)
             * In case i choose option 1
             */
            // default loan term: weekly
            $loanTermDate = Carbon::now()->addDays(7)->format(CommonConstant::DATE_FMT);
            DB::beginTransaction();
            try {
                // create new loan request
                $loanRequest = $this->store([
                    'user_id' => $userId,
                    'loan_no' => Common::generateCodeNumber(8),
                    'amount' => $amount,
                    'interest_rate' => $interestRate,
                    'loan_term_at' => $loanTermDate,
                ]);
                DB::commit();
                return $loanRequest;
            } catch (Exception $ex) {
                DB::rollBack();
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
            }
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }

    /**
     * update loan status
     * @param $loanId
     * @param $status
     * @return array|bool
     */
    public function updateLoanStatus($loanId, $status)
    {
        try {
            $loan = $this->findById($loanId);
            // check loan exist
            if (Common::isEmpty($loan)) {
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_LOAN_NOT_EXIST);
            }
            DB::beginTransaction();
            try {

                // update loan
                $result = $this->update($loanId, [
                    'status' => $status,
                ]);
                if (!$result) {
                    // update failure
                    return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_LOAN_UPDATE_FAIL);
                }
                DB::commit();
                return [];
            } catch (Exception $ex) {
                DB::rollBack();
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
            }
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }

    /**
     * repay loan
     * @param $loanId
     * @param $originalAmount
     * @param $interestAmount
     * @return array
     */
    public function repayLoan($loanId, $originalAmount, $interestAmount)
    {
        try {
            $loan = $this->findById($loanId);
            // check loan exist
            if (Common::isEmpty($loan)) {
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_LOAN_NOT_EXIST);
            }
            // begin processing repay
            DB::beginTransaction();
            try {
                $loanRepayment = new LoanRepayment();
                $loanRepayment->loan_id = $loanId;
                $loanRepayment->original_amount = $originalAmount;
                $loanRepayment->interest_amount = $interestAmount;
                $loanRepayment->save();
                DB::commit();
                return [
                    "repayment_id" => $loanRepayment->id,
                    "loan_id" => $loanId
                ];
            } catch (Exception $ex) {
                DB::rollBack();
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
            }
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }
}