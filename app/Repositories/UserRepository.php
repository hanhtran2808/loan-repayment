<?php


namespace App\Repositories;

use App\Constants\CommonConstant;
use App\Constants\ErrorCodeConstant;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Utils\Common;
use App\Utils\LogHelper;
use App\Utils\ResponseHelper;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;

class UserRepository extends AuthRepository implements UserRepositoryInterface
{
    public function __construct()
    {
        parent::__construct(new User());
    }

    #region get user token

    /**
     * get account info by auth token
     * @param $request
     * @param $guard
     * @return array|Authenticatable|null
     */
    public function getAccountInfo($request, $guard)
    {
        try {
            $account = $this->getAccount($request, $guard);
            if (Common::checkKeyHasObject(CommonConstant::KEY_ERROR, $account)) {
                // has error code happen
                return ResponseHelper::getErrorCode($account[CommonConstant::KEY_ERROR]);
            }
            return $account;
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return ResponseHelper::getErrorCode(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }

    #endregion get user token
}