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
        
        //distributors
        Route::post('login', 'AuthDistributorController@login');

        // with distributor auth
        Route::group(['middleware' => ['auth:admin']], function () {
            //distributors
            Route::put('update', 'AuthDistributorController@update');
            Route::post('logout', 'AuthDistributorController@logout');
            Route::put('changePassword' , 'AuthDistributorController@chnagePassword');
            Route::get('get/myProfile','AuthDistributorController@showMyProfile');

            // managment marchents
            Route::post('marchents/newAccount', 'Management\MarchentController@createNewAccount');
            Route::get('marchents/all', 'Management\MarchentController@allMyMarchents');
            Route::get('marchents/showAccount/{id}', 'Management\MarchentController@showAccount');
            Route::put('marchents/updateAccount/{id}', 'Management\MarchentController@updateAccount');

        });

    });

});

Route::prefix('chargers')->group(function () {
    Route::group(['namespace' => 'API\Charger'], function () {
        
        //chargers
        Route::post('register', 'AuthChargerController@register');
        Route::post('login', 'AuthChargerController@login');
        Route::get('get/{id}','AuthChargerController@show');


        // with charger  auth
        Route::group(['middleware' => ['auth:admin']], function () {
            //chargers
            Route::put('update', 'AuthChargerController@update');
            Route::post('logout', 'AuthChargerController@logout');
            Route::put('changePassword' , 'AuthChargerController@chnagePassword');

  
        });

    });

});


Route::prefix('marchents')->group(function () {
    Route::group(['namespace' => 'API\Marchent'], function () {
        
        //marchents
        Route::post('login', 'AuthMarchentController@login');

        // with marchent  auth
        Route::group(['middleware' => ['auth:admin']], function () {
            //marchents
            Route::put('update', 'AuthMarchentController@update');
            Route::post('logout', 'AuthMarchentController@logout');
            Route::put('changePassword' , 'AuthMarchentController@chnagePassword');
            Route::get('get/myProfile','AuthDistributorController@showMyProfile');

  
        });

    });

});
