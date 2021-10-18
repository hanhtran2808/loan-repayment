<?php


namespace App\Constants;


class CommonConstant
{
    const DATE_FMT = 'Y-m-d H:i:s';

    const KEY_ERROR = 'error';
    const KEY_CODE = 'code';
    const KEY_EXCEPTION = 'exception';
    const MESSAGE_KEY = 'message';
    const KEY_SUCCESS = 'success';
    const PARAMETER_AUTH_USER = 'authUser';
    const AUTH_GUARD_USER = 'api';

    const LOAN_STATUS_NEW = 0;
    const LOAN_STATUS_APPROVE = 1;
    const LOAN_STATUS_DONE = 2;
    const LOAN_STATUS_LIST = [self::LOAN_STATUS_APPROVE, self::LOAN_STATUS_DONE];

}