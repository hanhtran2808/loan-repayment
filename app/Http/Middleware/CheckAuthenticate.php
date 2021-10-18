<?php

namespace App\Http\Middleware;

use App\Constants\CommonConstant;
use App\Constants\ErrorCodeConstant;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Utils\Common;
use App\Utils\ResponseHelper;
use Closure;

class CheckAuthenticate
{
    /**
     * @var UserRepositoryInterface
     */
    protected $user_repo;

    public function __construct(
        UserRepositoryInterface $user_repo
    )
    {
        $this->user_repo = $user_repo;
    }

    /**
     * Handle the incoming request: check authenticate
     * @param $request
     * @param Closure $next
     * @param null $guard
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $authUser = $this->user_repo->getAccountInfo($request, $guard);
        if (Common::isEmpty($authUser)) {
            return ResponseHelper::getResponseError(ErrorCodeConstant::EC_AUTH_TOKEN_INVALID);
        }

        if (Common::checkKeyHasObject(CommonConstant::KEY_ERROR, $authUser)) {
            // has error code happen
            $error_code = $authUser[CommonConstant::KEY_ERROR];
            return ResponseHelper::getResponseError($error_code);
        }
        $request->merge(compact(CommonConstant::PARAMETER_AUTH_USER));
        return $next($request);
    }
}
