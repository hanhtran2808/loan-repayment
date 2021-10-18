<?php

namespace App\Models;

use App\Constants\TableConstant;
use Laravel\Passport\AuthCode;

class PassportAuthCode extends AuthCode
{
    protected $table = TableConstant::OAUTH_AUTH_CODES_TABLE_NAME;
}
