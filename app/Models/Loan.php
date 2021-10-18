<?php

namespace App\Models;

use App\Constants\TableConstant;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use Uuids;

    protected $guarded = [];
    protected $table = TableConstant::LOAN_TABLE_NAME;
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;
}
