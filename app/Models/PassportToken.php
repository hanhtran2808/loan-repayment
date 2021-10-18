<?php

namespace App\Models;

use App\Constants\TableConstant;
use Laravel\Passport\Token;

class PassportToken extends Token
{
    protected $table = TableConstant::OAUTH_ACCESS_TOKEN_TABLE_NAME;
}
