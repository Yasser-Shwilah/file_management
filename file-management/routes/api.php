<?php

use App\Http\Controllers\AdminAuthController as AAdminAuth;
use App\Http\Controllers\AuthController as AAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them
| will be assigned to the "api" middleware group. Make something great!
|
*/

// Group for user-related routes
Route::prefix('user')->group(function () {
    Route::post('register', [AAuth::class, 'register']);
    Route::post('login', [AAuth::class, 'login']);
});

// Group for admin-related routes
Route::prefix('admin')->group(function () {
    Route::post('register', [AAdminAuth::class, 'register']);
    Route::post('login', [AAdminAuth::class, 'login']);
});

// Group with authentication middleware
Route::group(['middleware' => ['auth:api', 'TransactionLogging']], function () {

    Route::post('logout', [AAuth::class, 'logout']);

    #################### FILE && GROUP Routes ####################
    Route::post('add/file', [\App\Http\Controllers\FileController::class, 'addFile']);
    Route::post('delete/file', [\App\Http\Controllers\FileController::class, 'deleteFile']);
    Route::post('CreateGroup', [\App\Http\Controllers\GroupController::class, 'CreateGroup']);
    Route::post('AddFileToGroup', [\App\Http\Controllers\GroupController::class, 'AddFileToGroup']);
    Route::post('deleteFileFromGroup', [\App\Http\Controllers\GroupController::class, 'deleteFileFromGroup']);
    Route::post('addUserToGroup', [\App\Http\Controllers\GroupController::class, 'addUserToGroup']);
    Route::post('deleteUserFromGroup', [\App\Http\Controllers\GroupController::class, 'deleteUserFromGroup']);
    Route::post('deleteGroup', [\App\Http\Controllers\GroupController::class, 'deleteGroup']);
    Route::post('getHistory', [\App\Http\Controllers\HistoryController::class, 'getHistory']);

    #################### Display Routes ####################

    Route::get('getMyFile', [\App\Http\Controllers\DisplayController::class, 'getMyFile']);
    Route::get('notifications', [\App\Http\Controllers\NotificationController::class, 'getNotifications']);

    Route::post('getStateFile', [\App\Http\Controllers\DisplayController::class, 'getStateFile']);
    Route::get('getMyGroup', [\App\Http\Controllers\DisplayController::class, 'getMyGroup']);
    Route::post('getGroupFile', [\App\Http\Controllers\DisplayController::class, 'getGroupFile']);
    Route::get('getAllUserInSystem', [\App\Http\Controllers\DisplayController::class, 'getAllUserInSystem']);
    Route::post('getAllUserInGroup', [\App\Http\Controllers\DisplayController::class, 'getAllUserInGroup']);
    Route::post('getAllFileCheck_InGroupForUser', [\App\Http\Controllers\DisplayController::class, 'getAllFileCheck_InGroupForUser']);

    #################### Check-in && Check-out ####################
    Route::post('check_in', [\App\Http\Controllers\FileOperationsController::class, 'check_in']);
    Route::post('readFile', [\App\Http\Controllers\FileOperationsController::class, 'readFile']);
    Route::post('saveFile', [\App\Http\Controllers\FileOperationsController::class, 'saveFile']);
    Route::post('check_outFile', [\App\Http\Controllers\FileOperationsController::class, 'check_outFile']);
});

Route::post('file/download', [\App\Http\Controllers\FileOperationsController::class, 'downloadFile'])->middleware('auth:api');

#################### Admin Routes ####################
Route::group(['middleware' => ['App\Http\Middleware\AdminAuth:admin-api', 'TransactionLogging']], function () {

    Route::post('admin/logout', [AAdminAuth::class, 'logout']);
    Route::get('admin/files/all', [\App\Http\Controllers\AdminController::class, 'getAllFileInSystem']);
    Route::post('admin/group/files', [\App\Http\Controllers\AdminController::class, 'getAllFileInGroup']);
    Route::get('admin/groups/all', [\App\Http\Controllers\AdminController::class, 'getAllGroupInSystem']);
});
