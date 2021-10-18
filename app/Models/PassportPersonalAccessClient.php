<?php

namespace App\Models;

use App\Constants\TableConstant;
use App\Traits\Uuids;
use Laravel\Passport\PersonalAccessClient;

class PassportPersonalAccessClient extends PersonalAccessClient
{
    use Uuids;
    protected $table = TableConstant::OAUTH_PERSONAL_ACCESS_CLIENTS_TABLE_NAME;

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
    protected $keyType = 'string';
}
