<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

use App\Constants\CommonConstant;


/**
 * login
 */
$router->group(['prefix' => 'user'], function () use ($router) {
    /**
     * login system
     */
    $router->post('/auth', 'LoginController@createToken');
    $router->post('/auth/token', 'Auth\AuthenticationController@issueToken');
});
/**
 * Authentication group
 */
$router->group(['middleware' => ['auth:' . CommonConstant::AUTH_GUARD_USER, 'scopes:' . CommonConstant::AUTH_GUARD_USER]], function () use ($router) {
    $router->group(['prefix' => 'loan'], function () use ($router) {
        /**
         * create loan request
         */
        $router->post('/create', 'LoanController@createLoanRequest');
        /**
         * update loan request
         */
        $router->post('/update', 'LoanController@updateLoanRequest');
        /**
         * repay loan
         */
        $router->post('/repay', 'LoanController@repayLoan');
    });
});
