<?php

use App\Http\Controllers\API\AuthController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::controller(AuthController::class)->group(function(){
     Route::post('/auth/login','login');
     Route::post('/auth/register','register');
     Route::post('/auth/email-verify','EmailVerify');
});

//test api guard
Route::middleware(['auth:api','scope:admin'])->group(function(){
     Route::post('/auth',function(){
        return User::all();
     });
});
