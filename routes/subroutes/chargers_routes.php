<?php

use Illuminate\Support\Facades\Route;



Route::prefix('chargers')->group(function () {
    Route::group(['namespace' => 'API\Charger'], function () {
        
        //chargers
        Route::post('login', 'AuthChargerController@login');


        // with charger  auth
        Route::group(['middleware' => ['auth:charger']], function () {
            //chargers
            Route::put('update', 'AuthChargerController@update');
            Route::post('logout', 'AuthChargerController@logout');
            Route::put('changePassword' , 'AuthChargerController@chnagePassword');
            Route::get('get/myProfile','AuthChargerController@showMyProfile');

  
            
          //masterStore products
          Route::get('products/masterStore/{store_id}/all','Products\MasterStoreController@index');
          Route::post('products/masterStore/{store_id}/search','Products\MasterStoreController@search');
          Route::get('products/masterStore/{id}','Products\MasterStoreController@show');

          Route::post('products/masterStore/details/all/{product_id}','Products\MasterStoreController@getProductDetails');
          Route::put('products/masterStore/details/{product_id}/{id}','Products\MasterStoreController@updateProductDetail');
          Route::get('products/masterStore/details/{product_id}/{id}','Products\MasterStoreController@showProductDetail');


        });

    });

});