<?php

namespace App\Http\Controllers\API\Marchent\Products;

use App\Http\Controllers\ApiController;

use App\Models\MasterStore;
use App\Models\StoreItem;
use App\Models\Store;

use App\Http\Requests\Distributors\Products\SearchRequest;

use App\Http\Resources\Marchents\Products\MasterStoreCollection;
use App\Http\Resources\Marchents\Products\MasterStoreResource;

use App\Http\Resources\Marchents\Products\ProductDetailResource;
use App\Http\Resources\Marchents\Products\ProductDetailsCollection;


class MasterStoreController extends ApiController
{

    public function index()
    {
        $products = MasterStore::where('store_id',getStoreID(auth()->user()->distributor_id))->paginate(20);

        if(!$products->count() > 0)
        {
			return $this->errorNotFound();
        }

        return new MasterStoreCollection($products);

    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;
        $products = MasterStore::where('store_id',getStoreID(auth()->user()->distributor_id))->when($key,function($q) use($key){
                              $q->where(function($q) use($key){
                                    $q->where('id','like','%'.$key.'%')
                                        ->orWhere('item_code','like','%'.$key.'%')
                                        ->orWhere('description','like','%'.$key.'%')
                                        ->orWhere('retail_price','like','%'.$key.'%')
                                        ->orWhere(function($q) use($key){
                                            $q->whereHas('subCategory',function($q) use($key){
                                                $q->where('name','like','%'.$key.'%');
                                            });
                                        }) ;
                              });
                          })
                        ->paginate(20);

                        
        return new MasterStoreCollection($products);

    }

    public function show($id)
    {
        $product = MasterStore::where('store_id',getStoreID(auth()->user()->distributor_id))->whereId($id)->first();
        if (empty($product)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new MasterStoreResource($product) );

    }

    public function getProductDetails($product_id)
    {
        $productDetails = StoreItem::where('master_store_id',$product_id)
                                    ->where('isCharger',1)->where('isSold',0)->paginate(20);

        if(!$productDetails->count() > 0)
        {
			return $this->errorNotFound();
        }
        return new ProductDetailsCollection($productDetails);

    }

    public function showProductDetail($product_id,$id)
    {
        $productDetail = StoreItem::where('master_store_id',$product_id)
                                  ->where('isCharger',1)->where('isSold',0)->whereId($id)->first();
        if (empty($productDetail)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new ProductDetailResource($productDetail) ); 
    }

    



}
