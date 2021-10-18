<?php


namespace App\Repositories\Interfaces;


interface AuthRepositoryInterface extends BaseRepositoryInterface
{
    public function getAccount($request, $guard);
}