<?php

use Illuminate\Support\Facades\Route;


Route::prefix('merchants')->group(function () {
    Route::group(['namespace' => 'API\Merchant'], function () {
        
        //merchants
        Route::post('login', 'MerchantController@login');

        // with Merchant  auth
        Route::group(['middleware' => ['auth:merchant']], function () {
            //merchants
            Route::put('update', 'MerchantController@update');
            Route::post('logout', 'MerchantController@logout');
            Route::put('changePassword' , 'MerchantController@chnagePassword');
            Route::get('get/myProfile','MerchantController@showMyProfile');


        //masterStore products
        Route::get('products/masterStore/all','Products\MasterStoreController@index');
        Route::post('products/masterStore/search','Products\MasterStoreController@search');
        Route::get('products/masterStore/{id}','Products\MasterStoreController@show');

        Route::get('products/masterStore/details/all/{product_id}','Products\MasterStoreController@getProductDetails');
        Route::get('products/masterStore/details/{product_id}/{id}','Products\MasterStoreController@showProductDetail');

          //sales orders 
          Route::get('products/salesOrders/all','Products\SalesOrderController@getSalesOrders');
          Route::post('products/salesOrders/store','Products\SalesOrderController@store');
          Route::get('products/salesOrders/destroy/{id}','Products\SalesOrderController@canceleOrder');
          Route::get('products/salesOrders/{id}','Products\SalesOrderController@show');

          Route::get('products/salesOrders/details/all/{po}','Products\SalesOrderController@mySalesOrderDetails');
          Route::get('products/salesOrders/details/{po}/{id}','Products\SalesOrderController@showMySalesOrderDetail');
        
  
        });

    });

});
