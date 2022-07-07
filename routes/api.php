<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\NovelController;
use App\Http\Controllers\API\ChapterController;
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

//novel
Route::controller(NovelController::class)->group(function(){
     Route::get('/novels','index');
     Route::get('/novels/{novel}','getNovel');
     Route::post('/novels/create','create');
     Route::put('/novels/{novel}/update','update');
     Route::delete('/novels/{novel}/delete','delete');
});

//chapter
Route::controller(ChapterController::class)->group(function(){
     Route::get('/chapters','index');
     Route::get('/chapters/{chapter}','getChapter');
     Route::post('/chapters/create','create');
     Route::put('/chapters/{chapter}/update','update');
     Route::delete('/chapters/{chapter}/delete','delete');
});

//category
Route::controller(CategoryController::class)->group(function(){
    Route::get('/categories','index');
    Route::get('/categories/{category}','getCategory');
    Route::post('/categories/create','create');
    Route::put('/categories/{category}/update','update');
    Route::delete('/categories/{category}/delete','delete');
});
