<?php

// namespace App\Http\Middleware;

// use Closure;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Log;

// class LogServiceCalls
// {
//     public function handle(Request $request, Closure $next)
//     {
//         try {
//             // إنشاء معرف فريد للطلب
//             $requestId = uniqid();
//             Log::info("Request ID: {$requestId} started for path: " . $request->path(), [
//                 'method' => $request->method(),
//                 'params' => $request->all(),
//             ]);

//             // تسجيل معلومات المستخدم إذا كان مسجلاً
//             $user = $request->user();
//             if ($user) {
//                 Log::info("Request ID: {$requestId} made by user: " . $user->id);
//             } else {
//                 Log::info("Request ID: {$requestId} made by an unauthenticated user.");
//             }


//             // حساب حجم البيانات المرسلة
//             $requestSize = strlen(json_encode($request->all()));
//             Log::info("Request ID: {$requestId} - Request size: {$requestSize} bytes");

//             // تنفيذ الطلب
//             $response = $next($request);

//             // تسجيل بيانات بعد التنفيذ
//             Log::info("Request ID: {$requestId} completed for path: " . $request->path());

//             // حساب حجم البيانات المستلمة
//             $responseSize = strlen($response->getContent());
//             Log::info("Request ID: {$requestId} - Response size: {$responseSize} bytes");

//             return $response;
//         } catch (\Exception $exception) {
//             // تسجيل الخطأ
//             Log::error("Exception occurred: " . $exception->getMessage(), [
//                 'path' => $request->path(),
//                 'method' => $request->method(),
//                 'params' => $request->all(),
//             ]);

//             throw $exception; // إعادة رمي الاستثناء
//         }
//     }
// }
