<?php

use Illuminate\Support\Facades\Route;


Route::prefix('marchents')->group(function () {
    Route::group(['namespace' => 'API\Marchent'], function () {
        
        //marchents
        Route::post('login', 'AuthMarchentController@login');

        // with marchent  auth
        Route::group(['middleware' => ['auth:marchent']], function () {
            //marchents
            Route::put('update', 'AuthMarchentController@update');
            Route::post('logout', 'AuthMarchentController@logout');
            Route::put('changePassword' , 'AuthMarchentController@chnagePassword');
            Route::get('get/myProfile','AuthMarchentController@showMyProfile');


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
