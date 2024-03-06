<?php

use Illuminate\Support\Facades\Route;



Route::prefix('distributors')->group(function () {
    Route::group(['namespace' => 'API\Distributor'], function () {
        
        //distributors
        Route::post('login', 'AuthDistributorController@login');

        // with distributor auth
        Route::group(['middleware' => ['auth:distributor']], function () {
            //distributors
            Route::put('update', 'AuthDistributorController@update');
            Route::post('logout', 'AuthDistributorController@logout');
            Route::put('changePassword' , 'AuthDistributorController@chnagePassword');
            Route::get('get/myProfile','AuthDistributorController@showMyProfile');

            // Management marchents
            Route::post('marchents/newAccount', 'Management\MarchentController@createNewAccount');
            Route::get('marchents/all', 'Management\MarchentController@allMyMarchents');
            Route::post('marchents/search', 'Management\MarchentController@search');
            Route::get('marchents/showAccount/{id}', 'Management\MarchentController@showAccount');
            Route::put('marchents/updateAccount/{id}', 'Management\MarchentController@updateAccount');
            Route::post('marchents/delete/{id}', 'Management\MarchentController@destroy');

            // Management marchents invitations
            Route::get('marchents/invitations/store', 'Management\InvitationController@storeInvitation');  

         ############################Products Settings#####################################################

          //masterStore products
          Route::get('products/masterStore/all','Products\MasterStoreController@index');
          Route::post('products/masterStore/search','Products\MasterStoreController@search');
          Route::put('products/masterStore/update/{id}','Products\MasterStoreController@update');
          Route::post('products/masterStore/destroy/{id}','Products\MasterStoreController@destroy');
          Route::get('products/masterStore/{id}','Products\MasterStoreController@show');

          Route::get('products/masterStore/details/all/{product_id}','Products\MasterStoreController@getProductDetails');
          Route::get('products/masterStore/details/{product_id}/{id}','Products\MasterStoreController@showProductDetail');



          //purchase orders 
          Route::get('products/purchaseOrders/all','Products\PurchaseOrderController@myPurchaseOrders');
          Route::get('products/purchaseOrders/{id}','Products\PurchaseOrderController@showmyPurchaseOrder');

          Route::get('products/purchaseOrders/details/all/{po}','Products\PurchaseOrderController@myPurchaseOrderDetails');
          Route::get('products/purchaseOrders/details/{po}/{id}','Products\PurchaseOrderController@showMyPurchaseOrderDetail');

        //sales orders 
          Route::get('products/salesOrders/all','Products\SalesOrderController@allSalesOrders');
          Route::get('products/salesOrders/destroy/{id}','Products\SalesOrderController@canceleOrder');
          Route::get('products/salesOrders/{id}','Products\SalesOrderController@show');

          Route::get('products/salesOrders/details/all/{po}','Products\SalesOrderController@salesOrderDetails');
          Route::get('products/salesOrders/details/{po}/{id}','Products\SalesOrderController@showSalesOrderDetail');

        });

    });

});
