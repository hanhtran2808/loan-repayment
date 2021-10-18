<?php

namespace App\Http\Controllers;

use App\Constants\CommonConstant;
use App\Constants\ErrorCodeConstant;
use App\Constants\TableConstant;
use App\Constants\ValidationConstant;
use App\Models\User;
use App\Utils\Common;
use App\Utils\LogHelper;
use App\Utils\ResponseHelper;
use App\Utils\ValidationHelper;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Psr\Http\Message\ResponseInterface;

class LoginController extends Controller
{
    /**
     * create token to access to system
     * @param Request $request
     * @return JsonResponse|ResponseInterface
     */
    public function createToken(Request $request)
    {
        try {
            $username = $request[ValidationConstant::USERNAME];
            $password = $request[ValidationConstant::PASSWORD];
            $params = [
                ValidationConstant::USERNAME => $username,
                ValidationConstant::PASSWORD => $password,
                'grant_type' => env('GRANT_TYPE_PASSWORD'),
                'client_id' => env('PASSPORT_CLIENT_ID'),
                'client_secret' => env('PASSPORT_CLIENT_SECRET')
            ];
            // check require and validation
            $validator = [
                ValidationConstant::USERNAME => 'required',
                ValidationConstant::PASSWORD => 'required'
            ];
            $validation_code = ValidationHelper::getValidationCode($params, $validator);
            if ($validation_code !== ErrorCodeConstant::ERROR_CODE_IS_SUCCESS) {
                return ResponseHelper::getResponseError($validation_code);
            }

            $user = new User();
            // find user in system
            $objUser = $user->findForPassport($username);
            if (empty($objUser)) {
                return ResponseHelper::getResponseError(ErrorCodeConstant::EC_USER_NO_EXIST);
            } else {
                if (!Hash::check($password, $objUser->password)) {
                    return ResponseHelper::getResponseError(ErrorCodeConstant::EC_USER_INCORRECT_PASSWORD);
                }
            }
            $params["user_id"] = $objUser->{"id"};
            $url = env('APP_URL') . env('API_GET_TOKEN');
            $proxy = Request::create($url, 'POST', $params);
            return \app()->dispatch($proxy);
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getResponseError(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }
}
