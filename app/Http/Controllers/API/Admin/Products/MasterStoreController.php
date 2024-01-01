<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\ApiController;

use App\Models\MasterStore;
use App\Models\StoreItem;

use App\Http\Requests\Admins\Products\SearchRequest;

use App\Http\Resources\Admins\Products\MasterStoreCollection;
use App\Http\Resources\Admins\Products\MasterStoreResource;

use App\Http\Resources\Admins\Products\ProductDetailResource;
use App\Http\Resources\Admins\Products\ProductDetailsCollection;


class MasterStoreController extends ApiController
{
    public function index($store_id)
    {
        $products = MasterStore::where('store_id',$store_id)->paginate(20);

        if(!$products->count() > 0)
        {
			return $this->errorNotFound();
        }

        return new MasterStoreCollection($products);

    }

    public function search($store_id,SearchRequest $request)
    {
        $key = $request->key;
        $products = MasterStore::where('store_id',$store_id)->when($key,function($q) use($key){
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
        $product = MasterStore::where('store_id',auth()->user()->myStore->id)->whereId($id)->first();
        if (empty($product)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new MasterStoreResource($product) );

    }

    public function getProductDetails($product_id)
    {
        $productDetails = StoreItem::where('master_store_id',$product_id)->paginate(20);

        if(!$productDetails->count() > 0)
        {
			return $this->errorNotFound();
        }
        return new ProductDetailsCollection($productDetails);

    }

    public function showProductDetail($product_id,$id)
    {
        $productDetail = StoreItem::where('master_store_id',$product_id)->whereId($id)->first();
        if (empty($productDetail)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new ProductDetailResource($productDetail) ); 
    }



}
