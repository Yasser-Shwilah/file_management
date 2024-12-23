<?php

namespace App\Http\Middleware;

use App\Models\Request;
use App\Models\Response;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Tymon\JWTAuth\Facades\JWTAuth;

class TransactionLogging
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
{
    DB::beginTransaction();

    $response = $next($request);
    $user = JWTAuth::parseToken()->authenticate();

    if (Auth::guard('api')->check()) {
        $req = Request::create([
            'user_id' => $user->id,
            'user_role' => 'user',
            'url' => URL::current(),
        ]);
    } else {
        $req = Request::create([
            'user_id' => $user->id,
            'user_role' => 'admin',
            'url' => URL::current(),
        ]);
    }

    // تحليل بيانات الاستجابة كـ JSON
    $responseData = json_decode($response->getContent());

    // تعيين قيمة افتراضية لـ state و error_number إذا لم تكن متوفرة
    $state = $responseData->status ?? 'default_state';
    $errorNumber = $responseData->errNum ?? 0;

    Response::create([
        'state' => $state,
        'error_number' => $errorNumber,
        'request_id' => $req->id
    ]);

    if ($errorNumber == 100) {
        DB::rollBack();
    } else {
        DB::commit();
    }

    return $response;
}

    
}
