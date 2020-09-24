<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\user\UserController;
use App\Http\Controllers\API\user\auth\UserAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('user/login', [UserAuthController::class, 'login'])->name('user.login');

Route::group(['prefix' => 'user', 'middleware' => 'auth:api', 'as' => 'user.'], function () {
    // get auth user
    Route::get('/', [UserController::class, 'index'])->name('get');
});