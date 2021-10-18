<?php
use App\Constants\ErrorCodeConstant;
use App\Constants\ValidationConstant;
return [
    'custom' => [
        ValidationConstant::USERNAME => [
            'required' => ErrorCodeConstant::EC_USERNAME_INPUT_REQUIRE,
        ],
        ValidationConstant::PASSWORD => [
            'required' => ErrorCodeConstant::EC_PASSWORD_INPUT_REQUIRE,
        ],
        ValidationConstant::LOAN_AMOUNT => [
            'required' => ErrorCodeConstant::EC_LOAN_AMOUNT_INPUT_REQUIRE,
            'numeric' => ErrorCodeConstant::EC_LOAN_AMOUNT_INVALID,
        ],
        ValidationConstant::LOAN_INTEREST_RATE => [
            'required' => ErrorCodeConstant::EC_LOAN_INTEREST_RATE_INPUT_REQUIRE,
            'min' => ErrorCodeConstant::EC_LOAN_INTEREST_RATE_INPUT_MIN_LENGTH,
            'max' => ErrorCodeConstant::EC_LOAN_INTEREST_RATE_INPUT_MAX_LENGTH,
            'numeric' => ErrorCodeConstant::EC_LOAN_INTEREST_RATE_INVALID,
        ],
        ValidationConstant::LOAN_ORIGINAL_AMOUNT => [
            'required' => ErrorCodeConstant::EC_LOAN_ORIGINAL_AMOUNT_INPUT_REQUIRE,
            'numeric' => ErrorCodeConstant::EC_LOAN_ORIGINAL_AMOUNT_INVALID,
        ],
        ValidationConstant::LOAN_INTEREST_AMOUNT => [
            'required' => ErrorCodeConstant::EC_LOAN_INTEREST_AMOUNT_INPUT_REQUIRE,
            'numeric' => ErrorCodeConstant::EC_LOAN_INTEREST_AMOUNT_INVALID,
        ],
        ValidationConstant::LOAN_ID => [
            'required' => ErrorCodeConstant::EC_LOAN_ID_INPUT_REQUIRE,
        ],
        ValidationConstant::LOAN_STATUS => [
            'required' => ErrorCodeConstant::EC_LOAN_STATUS_INPUT_REQUIRE,
            'in' => ErrorCodeConstant::EC_LOAN_STATUS_INVALID,
        ],
    ]
];
