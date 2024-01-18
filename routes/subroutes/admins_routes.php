<?php

use Illuminate\Support\Facades\Route;


Route::prefix('admins')->group(function () {
    Route::group(['namespace' => 'API\Admin'], function () {
        
        //admins
        Route::post('register', 'AuthAdminController@register');
        Route::post('login', 'AuthAdminController@login');

        // with admin  auth
        Route::group(['middleware' => ['auth:admin']], function () {
            //admins
            Route::put('update', 'AuthAdminController@update');
            Route::post('logout', 'AuthAdminController@logout');
            Route::put('changePassword' , 'AuthAdminController@chnagePassword');
            Route::get('get/myProfile','AuthAdminController@showMyProfile');
          #############################################################################################################
            
            // Management distributors
            Route::post('distributors/newAccount', 'Management\DistributorController@createNewAccount');
            Route::get('distributors/all', 'Management\DistributorController@allMyDistributors');
            Route::post('distributors/search', 'Management\DistributorController@search');
            Route::get('distributors/showAccount/{id}', 'Management\DistributorController@showAccount');
            Route::put('distributors/updateAccount/{id}', 'Management\DistributorController@updateAccount');
            Route::post('distributors/delete/{id}', 'Management\DistributorController@destroy');


           // Management chargers
            Route::post('chargers/newAccount', 'Management\ChargerController@createNewAccount');
            Route::get('chargers/all', 'Management\ChargerController@allMyChargers');
            Route::post('chargers/search', 'Management\ChargerController@search');
            Route::get('chargers/showAccount/{id}', 'Management\ChargerController@showAccount');
            Route::put('chargers/updateAccount/{id}', 'Management\ChargerController@updateAccount');
            Route::post('chargers/delete/{id}', 'Management\ChargerController@destroy');
            ###################################################################################################

           ############################Products Settings#####################################################

           //categories
           Route::get('products/categories/all','Products\CatgeoryController@index');
           Route::post('products/categories/search','Products\CatgeoryController@search');
           Route::post('products/categories/store','Products\CatgeoryController@store');
           Route::put('products/categories/update/{id}','Products\CatgeoryController@update');
           Route::post('products/categories/destroy/{id}','Products\CatgeoryController@destroy');
           Route::get('products/categories/{id}','Products\CatgeoryController@show');

          //sub-categories
          Route::get('products/subCategories/all','Products\SubCategoryController@index');
          Route::post('products/subCategories/search','Products\SubCategoryController@search');
          Route::post('products/subCategories/store','Products\SubCategoryController@store');
          Route::put('products/subCategories/update/{id}','Products\SubCategoryController@update');
          Route::post('products/subCategories/destroy/{id}','Products\SubCategoryController@destroy');
          Route::get('products/subCategories/{id}','Products\SubCategoryController@show');


          //secure-typess
          Route::get('products/secureTypes/all','Products\ProductSecureTypeController@index');
          Route::post('products/secureTypes/search','Products\ProductSecureTypeController@search');
          Route::post('products/secureTypes/store','Products\ProductSecureTypeController@store');
          Route::put('products/secureTypes/update/{id}','Products\ProductSecureTypeController@update');
          Route::post('products/secureTypes/destroy/{id}','Products\ProductSecureTypeController@destroy');
          Route::get('products/secureTypes/{id}','Products\ProductSecureTypeController@show');

          //masterFile products
          Route::get('products/masterFile/all','Products\MasterFileController@index');
          Route::post('products/masterFile/search','Products\MasterFileController@search');
          Route::post('products/masterFile/store','Products\MasterFileController@store');
          Route::put('products/masterFile/update/{id}','Products\MasterFileController@update');
          Route::post('products/masterFile/destroy/{id}','Products\MasterFileController@destroy');
          Route::get('products/masterFile/{id}','Products\MasterFileController@show');

          //distributors stores
          Route::get('products/stores/all','Products\StoreController@index');
          Route::post('products/stores/search','Products\StoreController@search');
          Route::post('products/stores/destroy/{id}','Products\StoreController@destroy');
          Route::get('products/stores/{id}','Products\StoreController@show');


          //purchase orders 
          Route::get('products/purchaseOrders/all','Products\PurchaseOrderController@getPurchaseOrders');
          Route::post('products/purchaseOrders/store','Products\PurchaseOrderController@store');
          Route::get('products/purchaseOrders/destroy/{id}','Products\PurchaseOrderController@canceleOrder');
          Route::get('products/purchaseOrders/confirmOrder/{id}','Products\PurchaseOrderController@confirmOrder');
          Route::get('products/purchaseOrders/receiveOrder/{id}','Products\PurchaseOrderController@receiveOrder');

          Route::get('products/purchaseOrders/{id}','Products\PurchaseOrderController@show');
          Route::get('products/purchaseOrders/details/all/{po}','Products\PurchaseOrderController@myPurchaseOrderDetails');
          Route::get('products/purchaseOrders/details/{po}/{id}','Products\PurchaseOrderController@showMyPurchaseOrderDetail');

          //masterStore products
          Route::get('products/masterStore/{store_id}/all','Products\MasterStoreController@index');
          Route::post('products/masterStore/{store_id}/search','Products\MasterStoreController@search');
          Route::get('products/masterStore/{id}','Products\MasterStoreController@show');

          Route::get('products/masterStore/details/all/{product_id}','Products\MasterStoreController@getProductDetails');
          Route::get('products/masterStore/details/{product_id}/{id}','Products\MasterStoreController@showProductDetail');

        #################################################################################################################################  

          Route::group(['namespace'=>'Wallet'], function(){
            // with user  auth
            Route::group(['middleware' => ['auth:admin']], function () {

               //paymentAccounts
                Route::get('wallets/payments/accounts/all','PaymentAccountController@index');
                Route::get('wallets/payments/accounts/{id}','PaymentAccountController@show');

                //payments transactions
                Route::get('wallets/payments/transactions/all', 'PaymentTransactionController@allPaymentsTransactions');
                Route::post('wallets/payments/transactions/search', 'PaymentTransactionController@searchPaymentTransactions');
                Route::post('wallets/payments/transactions/verify/{id}', 'PaymentTransactionController@verifyPaymentTransaction');
                Route::get('wallets/payments/transactions/{id}', 'PaymentTransactionController@showPaymentTransaction');
              
                //wallets
                Route::get('wallets/myAccount','WalletAccountController@show');
                Route::post('wallets/paymentAccounts/verify','WalletAccountController@verifyAccount');
    
    
                //wallets transactions
                Route::post('wallets/transactions/make','WalletAccountController@makeWalletTransaction');
                Route::get('wallets/transactions/all', 'WalletTransactionController@getWalletTransactions');
                Route::post('wallets/transactions/search', 'WalletTransactionController@searchWalletTransactions');
                Route::get('wallets/transactions/{id}', 'WalletTransactionController@showWalletTransaction');
    
    
               });
            });
  
        });

    });

});
