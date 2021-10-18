<?php

namespace App\Models;

use App\Constants\TableConstant;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Lumen\Auth\Authorizable;
use Laravel\Passport\HasApiTokens;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use HasApiTokens, Authenticatable, Authorizable, HasFactory;

    protected $guarded = [];
    protected $table = TableConstant::USER_TABLE_NAME;
    protected $hidden = ["password"];
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;


    /**
     * Find the user identified by the given $identifier.
     *
     * @param $identifier email
     * @return mixed
     */
    public function findForPassport($identifier)
    {
        try {
            $user = User::where(
                function ($q) use ($identifier) {
                    $q->where('email', $identifier);
                }
            )
                ->first();
            return $user;
        } catch (Exception $ex) {
            // write log to tracking error
            return null;
        }
    }
}
