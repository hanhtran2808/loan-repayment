<?php


namespace App\Repositories;


use App\Constants\CommonConstant;
use App\Constants\ErrorCodeConstant;
use App\Repositories\Interfaces\AuthRepositoryInterface;
use App\Utils\Common;
use App\Utils\LogHelper;
use App\Utils\ResponseHelper;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    public function __construct($model)
    {

        $this->model = $model;
    }

    #region get account by token

    /**
     * get account info by auth token
     * @param $request
     * @param $guard
     * @return array|Authenticatable|null
     */
    public function getAccount($request, $guard)
    {
        try {
            // check request header has access token or not
            $access_token = Common::getAuthorizationHeader($request);
            if (Common::isEmpty($access_token)) {
                // no access token
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_AUTH_TOKEN_REQUIRE);
            }
            $account = $this->getAccountByToken($guard);
            if (Common::checkKeyHasObject(CommonConstant::KEY_ERROR, $account)) {
                // has error code happen
                return ResponseHelper::getErrorCode($account[CommonConstant::KEY_ERROR]);
            }
            // get token
            $token = $account->token();
            if (Common::isEmpty($token) || $token->revoked == 1) {
                // can not find token or revoked
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_AUTH_TOKEN_INVALID);
            }
            // check token is expire or not
            if (Carbon::parse($token->expires_at) < Carbon::now()) {
                // in case expired
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_AUTH_TOKEN_EXPIRE);
            }
            return $account;
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }

    /**
     * get account from guard and scope
     * @param $guard
     * @return array|Authenticatable|null
     */
    private function getAccountByToken($guard)
    {
        try {
            // get account info by guard
            $account = Auth::guard($guard)->user();
            if (Common::isEmpty($account)) {
                // can not find account
                return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_AUTH_TOKEN_INVALID);
            }
            return $account;
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }

    #endregion get account by token
}