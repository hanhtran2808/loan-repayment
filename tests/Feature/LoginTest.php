<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;
use App\Constants\ErrorCodeConstant;

class LoginTest extends TestCase
{
    /**
     * test case: account is incorrect password
     */
    public function testIncorrectPassword()
    {
        $requestBody = [
            'username' => "kaya.reilly@example.org",
            "password" => "Password1235"
        ];

        $this->json('POST', 'user/auth', $requestBody, ['Accept' => 'application/json'])
            ->seeJsonEquals([
                'error' => [
                    'code' => ErrorCodeConstant::EC_USER_INCORRECT_PASSWORD
                ],
            ]);
    }

    /**
     * test case: missing password input
     */
    public function testMissPasswordInput()
    {
        $requestBody = [
            'username' => "kaya.reilly@example.org",
        ];

        $this->json('POST', 'user/auth', $requestBody, ['Accept' => 'application/json'])
            ->seeJsonEquals([
                'error' => [
                    'code' => ErrorCodeConstant::EC_PASSWORD_INPUT_REQUIRE
                ],
            ]);
    }

    /**
     * test case: missing username input
     */
    public function testMissUsernameInput()
    {
        $requestBody = [
            "password" => "Password1235"
        ];

        $this->json('POST', 'user/auth', $requestBody, ['Accept' => 'application/json'])
            ->seeJsonEquals([
                'error' => [
                    'code' => ErrorCodeConstant::EC_USERNAME_INPUT_REQUIRE
                ],
            ]);
    }

    /**
     * test case: account has not exist in system
     */
    public function testUserHasNoExist()
    {
        $requestBody = [
            'username' => "test.reilly@example.org",
            "password" => "Password1234"
        ];

        $this->json('POST', 'user/auth', $requestBody, ['Accept' => 'application/json'])
            ->seeJsonEquals([
                'error' => [
                    'code' => ErrorCodeConstant::EC_USER_NO_EXIST
                ],
            ]);
    }
}
