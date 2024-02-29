<?php

use Illuminate\Support\Facades\Route;

Route::prefix('common')->group(function(){

    Route::group(['namespace'=>'API\Common'],function(){

           //categories
           Route::get('products/categories/all','Products\CatgeoryController@index');
           Route::post('products/categories/search','Products\CatgeoryController@search');
           Route::get('products/categories/{id}','Products\CatgeoryController@show');

          //sub-categories
          Route::get('products/subCategories/all','Products\SubCategoryController@index');
          Route::get('products/subCategories/byCategory/{category_id}','Products\SubCategoryController@getByCategoryID');

          Route::post('products/subCategories/search','Products\SubCategoryController@search');
          Route::get('products/subCategories/{id}','Products\SubCategoryController@show');


          //secure-typess
          Route::get('products/secureTypes/all','Products\ProductSecureTypeController@index');
          Route::post('products/secureTypes/search','Products\ProductSecureTypeController@search');
          Route::get('products/secureTypes/{id}','Products\ProductSecureTypeController@show');


          //distributors stores
          Route::get('products/stores/all','Products\StoreController@index');
          Route::post('products/stores/search','Products\StoreController@search');
          Route::get('products/stores/{id}','Products\StoreController@show');


         
        Route::group(['namespace'=>'Wallet'], function(){
             // with user  auth
             Route::group(['middleware' => ['auth:distributor','auth:marchent']], function () {

                //paymentAccounts
                 Route::post('wallets/payments/accounts/store','PaymentAccountController@store');
                 Route::get('wallets/payments/accounts/removal','PaymentAccountController@removal');
                 Route::get('wallets/payments/accounts/myAccount','PaymentAccountController@show');

                 //payments transactions
                 Route::get('wallets/payments/transactions/all', 'PaymentTransactionController@getPaymentTransactions');
                 Route::post('wallets/payments/transactions/search', 'PaymentTransactionController@searchPaymentTransactions');
                 Route::get('wallets/payments/transactions/{id}', 'PaymentTransactionController@showPaymentTransaction');
                
                 //wallets
                 Route::get('wallets/myAccount','WalletAccountController@show');
                 Route::post('wallets/payments/accounts/verify','WalletAccountController@verifyAccount');
     
     
                 //wallets transactions
                 Route::post('wallets/transactions/make','WalletAccountController@makeWalletTransaction');
                 Route::get('wallets/transactions/all', 'WalletTransactionController@getWalletTransactions');
                 Route::post('wallets/transactions/search', 'WalletTransactionController@searchWalletTransactions');
                 Route::get('wallets/transactions/{id}', 'WalletTransactionController@showWalletTransaction');

     
             });
        });
           

        Route::group(['namespace'=>'Chat'], function(){
            // with user  auth
            Route::group(['middleware' => ['auth:distributor','auth:marchent']], function () {

                //chats

                Route::get('chats/getChats','ChatController@getChats');
                Route::post('chats/createChat','ChatController@createChat');
                Route::post('chats/searchUsers','ChatController@searchUsers');
                Route::get('chats/{chat}','ChatController@getChatById');
                Route::post('chats/messages/send','ChatController@sendTextMessage');
                Route::get('chats/messages/{message}','ChatController@messageStatus');
    
    
            });
       });
    
 

    });

});

