<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::prefix('users')->group(function () {
    Route::group(['namespace' => 'API\User'], function () {
        
        //users
        Route::post('register', 'AuthUserController@register');
        Route::post('login', 'AuthUserController@login');
        Route::get('get/{id}','AuthUserController@show');


        // with user  auth
        Route::group(['middleware' => ['auth:api']], function () {
            //users
            Route::put('update', 'AuthUserController@update');
            Route::post('logout', 'AuthUserController@logout');
            Route::put('changePassword' , 'AuthUserController@chnagePassword');

  

        });

    });

});
