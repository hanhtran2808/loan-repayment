<?php


namespace App\Constants;


class ErrorCodeConstant
{
    const ERROR_CODE_IS_SUCCESS = 0; // no error
    const EC_EXCEPTION_LOGIC = 1; // exception error
    const EC_USER_NO_EXIST = 2; // user has not in system
    const EC_USER_INCORRECT_PASSWORD = 3; // password is not correct
    const EC_AUTH_TOKEN_REQUIRE = 4; // require auth header
    const EC_AUTH_TOKEN_INVALID = 5; // auth token is invalid
    const EC_AUTH_TOKEN_EXPIRE = 6; // auth token has expired
    //input username
    const EC_USERNAME_INPUT_REQUIRE = 7;
    //input password
    const EC_PASSWORD_INPUT_REQUIRE = 8;
    //input loan amount
    const EC_LOAN_AMOUNT_INPUT_REQUIRE = 9;
    const EC_LOAN_AMOUNT_INVALID = 10;
    //input loan interest rate
    const EC_LOAN_INTEREST_RATE_INPUT_REQUIRE = 11;
    const EC_LOAN_INTEREST_RATE_INPUT_MIN_LENGTH = 12;
    const EC_LOAN_INTEREST_RATE_INPUT_MAX_LENGTH = 13;
    const EC_LOAN_INTEREST_RATE_INVALID = 14;
    //input loan original amount
    const EC_LOAN_ORIGINAL_AMOUNT_INPUT_REQUIRE = 15;
    const EC_LOAN_ORIGINAL_AMOUNT_INVALID = 16;
    //input loan interest amount
    const EC_LOAN_INTEREST_AMOUNT_INPUT_REQUIRE = 17;
    const EC_LOAN_INTEREST_AMOUNT_INVALID = 18;
    //input loan id
    const EC_LOAN_ID_INPUT_REQUIRE = 19;

    const EC_LOAN_NOT_EXIST = 20;
    const EC_LOAN_UPDATE_FAIL = 21;
    //input loan status
    const EC_LOAN_STATUS_INPUT_REQUIRE = 22;
    const EC_LOAN_STATUS_INVALID = 23;

}