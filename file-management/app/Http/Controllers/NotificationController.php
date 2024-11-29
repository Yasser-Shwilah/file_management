<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function getNotifications(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'unreadNotifications' => $user->unreadNotifications,
            'readNotifications' => $user->readNotifications,
        ]);
    }
}
