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

    });

});

