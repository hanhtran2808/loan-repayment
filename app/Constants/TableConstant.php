<?php


namespace App\Constants;


class TableConstant
{
    #region tables
    const SCHEMA = '';
    const OAUTH_CLIENT_TABLE_NAME = self::SCHEMA . 'oauth_clients';
    const OAUTH_ACCESS_TOKEN_TABLE_NAME = self::SCHEMA . 'oauth_access_tokens';
    const OAUTH_REFRESH_TOKEN_TABLE_NAME = self::SCHEMA . 'oauth_refresh_tokens';
    const OAUTH_AUTH_CODES_TABLE_NAME = self::SCHEMA . 'oauth_auth_codes';
    const OAUTH_PERSONAL_ACCESS_CLIENTS_TABLE_NAME = self::SCHEMA . 'oauth_personal_access_clients';
    const USER_TABLE_NAME = self::SCHEMA . 'users';
    const LOAN_TABLE_NAME = self::SCHEMA . 'loans';
    const LOAN_REPAYMENT_TABLE_NAME = self::SCHEMA . 'loan_repayment';
    #endregion tables
}