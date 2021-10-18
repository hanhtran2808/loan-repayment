<?php


namespace App\Utils;

use App\Constants\ErrorCodeConstant;
use Illuminate\Validation\ValidationException;
use Validator;

class ValidationHelper
{
    /**
     * check validation from inputs
     * @param $arrValue
     * @param $arrValidation
     * @return bool
     */
    public static function checkValidation($arrValue, $arrValidation)
    {
        $validator = Validator::make($arrValue, $arrValidation);
        if ($validator->fails()) {
            return false;
        }
        return true;
    }
    /**
     * get validation code
     * @param $arrValue
     * @param $arrValidation
     * @return int: in case all input is valid => return 0
     */
    public static function getValidationCode($arrValue, $arrValidation)
    {
        $validator = Validator::make($arrValue, $arrValidation);
        if ($validator->fails()) {
            $error_code = ErrorCodeConstant::ERROR_CODE_IS_SUCCESS;
            $errors = (new ValidationException($validator))->errors();
            foreach ($errors as $key => $value) {
                $error_code = (int)$value[0];
                break;
            }
            return $error_code;
        }
        return ErrorCodeConstant::ERROR_CODE_IS_SUCCESS;
    }
}