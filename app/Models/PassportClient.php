<?php

namespace App\Models;

//use App\Constant;
use App\Constants\TableConstant;
use App\Traits\Uuids;
use Laravel\Passport\Client;

class PassportClient extends Client
{
    use Uuids;
    protected $table = TableConstant::OAUTH_CLIENT_TABLE_NAME;
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $keyType = 'string';
}
