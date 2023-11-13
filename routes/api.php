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


Route::prefix('admins')->group(function () {
    Route::group(['namespace' => 'API\Admin'], function () {
        
        //admins
        Route::post('register', 'AuthAdminController@register');
        Route::post('login', 'AuthAdminController@login');
        Route::get('get/{id}','AuthAdminController@show');


        // with admin  auth
        Route::group(['middleware' => ['auth:admin']], function () {
            //users
            Route::put('update', 'AuthAdminController@update');
            Route::post('logout', 'AuthAdminController@logout');
            Route::put('changePassword' , 'AuthAdminController@chnagePassword');

  
        });

    });

});



Route::prefix('distributors')->group(function () {
    Route::group(['namespace' => 'API\Distributor'], function () {
        
        //admins
        Route::post('register', 'AuthDistributorController@register');
        Route::post('login', 'AuthDistributorController@login');
        Route::get('get/{id}','AuthDistributorController@show');


        // with admin  auth
        Route::group(['middleware' => ['auth:admin']], function () {
            //users
            Route::put('update', 'AuthDistributorController@update');
            Route::post('logout', 'AuthDistributorController@logout');
            Route::put('changePassword' , 'AuthDistributorController@chnagePassword');

  
        });

    });

});

Route::prefix('chargers')->group(function () {
    Route::group(['namespace' => 'API\Charger'], function () {
        
        //admins
        Route::post('register', 'AuthChargerController@register');
        Route::post('login', 'AuthChargerController@login');
        Route::get('get/{id}','AuthChargerController@show');


        // with admin  auth
        Route::group(['middleware' => ['auth:admin']], function () {
            //users
            Route::put('update', 'AuthChargerController@update');
            Route::post('logout', 'AuthChargerController@logout');
            Route::put('changePassword' , 'AuthChargerController@chnagePassword');

  
        });

    });

});


Route::prefix('marchents')->group(function () {
    Route::group(['namespace' => 'API\Marchent'], function () {
        
        //admins
        Route::post('register', 'AuthMarchentController@register');
        Route::post('login', 'AuthMarchentController@login');
        Route::get('get/{id}','AuthMarchentController@show');


        // with admin  auth
        Route::group(['middleware' => ['auth:admin']], function () {
            //users
            Route::put('update', 'AuthMarchentController@update');
            Route::post('logout', 'AuthMarchentController@logout');
            Route::put('changePassword' , 'AuthMarchentController@chnagePassword');

  
        });

    });

});
