<?php


namespace App\Utils;


use App\Constants\CommonConstant;
use App\Constants\LogConstant;
use Illuminate\Http\JsonResponse;

class ResponseHelper
{
    /**
     * get error code
     * @param $code
     * @return array
     */
    public static function getErrorCode($code)
    {
        return [
            CommonConstant::KEY_ERROR => $code,
        ];
    }
    /**
     * get response error code
     * @param $code
     * @return JsonResponse
     */
    public static function getResponseError($code = '')
    {
        return response()->json([
            CommonConstant::KEY_ERROR => [
                CommonConstant::KEY_CODE => $code
            ],
        ], 200);
    }

    /**
     * get response success
     * @param array $result
     * @return JsonResponse
     */
    public static function getResponseSuccess($result = [])
    {
        return response()->json([
            CommonConstant::KEY_SUCCESS => Common::isEmpty($result) ? new \stdClass() : $result,
        ], 200);
    }

    /**
     * get response data
     * @param $data
     * @param int $status
     * @return JsonResponse
     */
    public static function getResponseData($data, $status = 500)
    {
        return response()->json($data, $status);
    }

}