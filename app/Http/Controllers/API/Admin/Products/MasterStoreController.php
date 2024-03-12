<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\ApiController;

use App\Models\MasterStore;
use App\Models\StoreItem;

use App\Http\Requests\Admins\Products\SearchRequest;
use App\Http\Requests\Admins\Products\SetSecureTypeValueRequest;
use App\Http\Requests\Admins\Products\FilterProductDetailsRequest;


use App\Http\Resources\Admins\Products\MasterStoreCollection;
use App\Http\Resources\Admins\Products\MasterStoreResource;

use App\Http\Resources\Admins\Products\ProductDetailResource;
use App\Http\Resources\Admins\Products\ProductDetailsCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;


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

    public function getProductDetails($product_id,FilterProductDetailsRequest $request)
    {
        $productDetails = StoreItem::where('master_store_id',$product_id);

        if($request->input('status') == 'charged')
        {
            $productDetails->where('isCharger',1);
        }

        if($request->input('status') == 'non-charged')
        {
            $productDetails->where('isCharger',0);
        }

        if(!$productDetails->count() > 0)
        {
			return $this->errorNotFound();
        }
        return new ProductDetailsCollection($productDetails->paginate(20));

    }

    public function showProductDetail($product_id,$id)
    {
        $productDetail = StoreItem::where('master_store_id',$product_id)->whereId($id)->first();
        if (empty($productDetail)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new ProductDetailResource($productDetail) ); 
    }

    
    public function SetSecureTypeValue($product_id,$id,SetSecureTypeValueRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $productDetail = StoreItem::where('master_store_id',$product_id)->whereId($id)->first();
            if (empty($productDetail)) {
                        return $this->errorStatus(__('msg.errorNotFound'));
                    }
            $productDetail->update([
                'product_secure_type_value'=>$request->product_secure_type_value,
                'isCharger'=>1,
                'charger_date'=>Carbon::now(),
                'charger_id'=>Auth::user()->id //it's replaced from charger role to admin role as the last update of project due to the new requirements
            ]);


            return $this->respondWithItem(new ProductDetailResource($productDetail) ); 

        }


    }




}
