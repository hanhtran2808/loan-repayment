<?php


namespace App\Utils;

use Exception;
use Illuminate\Support\Facades\Log;

class LogHelper
{
    /**
     * write error log exception
     * @param $className: Class contain function call Log helper
     * @param $functionName: function name call Log Helper
     * @param $message: content use to write log
     * @param Exception $ex
     */
    public static function writeLogException($className, $functionName, $message, Exception $ex)
    {
        Log::info($className . '=> ' . $functionName . ': ' . $message, [
            'code' => $ex->getCode(),
            'error' => $ex->getMessage()
        ]);
    }

    /**
     * write log
     * @param $className
     * @param $func
     * @param $message
     * @param $context
     */
    public static function writeLog($className, $func, $message, $context)
    {
        Log::info($className . '=> ' . $func . ': ' . $message, $context);
    }
}