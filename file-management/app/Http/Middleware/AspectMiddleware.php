<?php

namespace App\Http\Middleware;

use App\Aspects\LogAspect;
use Closure;

class AspectMiddleware
{
    private $logAspect;

    public function __construct(LogAspect $logAspect)
    {
        $this->logAspect = $logAspect;
    }

    public function handle($request, Closure $next)
    {
        try {
            // before
            $this->logAspect->before($request);

            // تنفيذ الطلب
            $response = $next($request);

            //after
            $this->logAspect->after($request, $response);

            return $response;
        } catch (\Exception $exception) {
            $this->logAspect->onException($request, $exception);

            throw $exception;
        }
    }
}
