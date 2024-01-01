<?php

namespace App\Http\Controllers\API\Charger\Products;

use App\Http\Controllers\ApiController;

use App\Models\MasterStore;
use App\Models\StoreItem;

use App\Http\Requests\Chargers\Products\SearchRequest;
use App\Http\Requests\Chargers\Products\UpdateProductDetailRequest;
use App\Http\Requests\Chargers\Products\FilterProductDetailsRequest;

use App\Http\Resources\Chargers\Products\MasterStoreCollection;
use App\Http\Resources\Chargers\Products\MasterStoreResource;

use App\Http\Resources\Chargers\Products\ProductDetailResource;
use App\Http\Resources\Chargers\Products\ProductDetailsCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Carbon\Carbon;


class MasterStoreController extends ApiController
{
    public function index()
    {
        $products = MasterStore::where('store_id',auth()->user()->myStore->id)->paginate(20);

        if(!$products->count() > 0)
        {
			return $this->errorNotFound();
        }

        return new MasterStoreCollection($products);

    }

    public function search(SearchRequest $request)
    {
        $key = $request->key;
        $products = MasterStore::where('store_id',auth()->user()->myStore->id)->when($key,function($q) use($key){
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
                                   // ->where('isCharger',-1)->paginate(20);
       // dd($request->input('status'));
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
        $productDetail = StoreItem::where('master_store_id',$product_id)
                                  ->where('isCharger',0)->whereId($id)->first();
        if (empty($productDetail)) {
                    return $this->errorStatus(__('msg.errorNotFound'));
                }
        return $this->respondWithItem(new ProductDetailResource($productDetail) ); 
    }


    public function updateProductDetail($product_id,$id,UpdateProductDetailRequest $request)
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
                'charger_id'=>Auth::user()->id
            ]);


            return $this->respondWithItem(new ProductDetailResource($productDetail) ); 

        }


    }



}
