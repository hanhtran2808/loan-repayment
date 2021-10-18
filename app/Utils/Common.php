<?php


namespace App\Utils;


use App\Constants\CommonConstant;
use Exception;

class Common
{
    /**
     * check null or empty
     * @param $var
     * @return bool
     */
    public static function isEmpty($var)
    {
        return blank($var);
    }

    /**
     * get access token in request header
     * @param $request
     * @return string
     */
    public static function getAuthorizationHeader($request)
    {
        try {
            $access_token = empty($request->header('Authorization')) ? '' : $request->header('Authorization');
            if (empty($access_token)) {
                return '';
            }
            return $access_token;
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return '';
        }
    }

    /**
     * check key has exist in object
     * @param $key
     * @param $object
     * @param bool $is_request
     * @return bool
     */
    public static function checkKeyHasObject($key, $object, $is_request = false)
    {
        try {
            if ($is_request) {
                return $object->has($key);
            }
            // check object is array
            if (!is_array($object)) {
                return false;
            }
            return array_key_exists($key, $object);
        } catch (Exception $ex) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $ex);
            return false;
        }

    }

    /**
     * generate code number
     * @param int $length
     * @return string
     */
    public static function generateCodeNumber($length = 8)
    {
        return substr(number_format(time() * rand(),0,'',''),0,$length);
    }

}