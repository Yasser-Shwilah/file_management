<?php

namespace App\Aspects;

use Illuminate\Support\Facades\Log;

class LogAspect
{
    public function before($request)
    {
        $requestId = uniqid();
        $request->attributes->set('requestId', $requestId);

        Log::info("Request ID: {$requestId} started for path: " . $request->path(), [
            'method' => $request->method(),
            'params' => $request->all(),
        ]);

        $user = $request->user();
        if ($user) {
            Log::info("Request ID: {$requestId} made by user: " . $user->id);
        } else {
            Log::info("Request ID: {$requestId} made by an unauthenticated user.");
        }
    }

    public function after($request, $response)
    {
        $requestId = $request->attributes->get('requestId');
        Log::info("Request ID: {$requestId} completed for path: " . $request->path(), [
            'response_size' => strlen($response->getContent()),
        ]);
    }

    public function onException($request, $exception)
    {
        $requestId = $request->attributes->get('requestId');
        Log::error("Request ID: {$requestId} - Exception occurred: " . $exception->getMessage(), [
            'path' => $request->path(),
            'method' => $request->method(),
            'params' => $request->all(),
        ]);
    }
}
