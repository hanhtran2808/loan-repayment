<?php

namespace App\Http\Controllers\Auth;

use App\Constants\CommonConstant;
use App\Constants\ErrorCodeConstant;
use App\Utils\LogHelper;
use App\Utils\ResponseHelper;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\ResponseFactory;
use \Laravel\Passport\Http\Controllers\AccessTokenController as ATC;
use League\OAuth2\Server\Exception\OAuthServerException;
use Psr\Http\Message\ServerRequestInterface;

class AuthenticationController extends ATC
{
    /**
     * get user access token that using passport
     * @param ServerRequestInterface $request
     * @return JsonResponse|Response|ResponseFactory
     */
    public function issueToken(ServerRequestInterface $request)
    {
        try {
            //generate token
            $tokenResponse = parent::issueToken($request);
            //convert response to json string
            $content = $tokenResponse->getContent();

            // $tokenInfo will contain the usual Laravel passport token response.
            //convert json to array
            $data = json_decode($content, true);

            if(isset($data["error"])){
                return ResponseHelper::getResponseError();
            }

            // Then we just add the user to the response before returning it.
            return ResponseHelper::getResponseSuccess($data);
        }
        catch (ModelNotFoundException $e) { // email notfound
            //return error message
            LogHelper::writeLog(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, [
                CommonConstant::MESSAGE_KEY => $e->getMessage(),
                'region' => 'ModelNotFoundException'
            ]);
            return ResponseHelper::getResponseError(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
        catch (OAuthServerException $e) { //password not correct..token not granted
            //return error message
            LogHelper::writeLog(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, [
                CommonConstant::MESSAGE_KEY => $e->getMessage(),
                'region' => 'OAuthServerException'
            ]);
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $e);
            return ResponseHelper::getResponseError(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
        catch (Exception $e) {
            LogHelper::writeLogException(__CLASS__, __FUNCTION__, CommonConstant::KEY_EXCEPTION, $e);
            return ResponseHelper::getResponseError(ErrorCodeConstant::EC_EXCEPTION_LOGIC);
        }
    }
}
