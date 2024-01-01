<?php

namespace App\Http\Controllers\API\Distributor\Products;

use App\Http\Controllers\ApiController;

use App\Models\MasterStore;
use App\Models\StoreItem;

use App\Http\Requests\Distributors\Products\SearchRequest;
use App\Http\Requests\Distributors\Products\UpdateMasterStoreRequest;
use App\Http\Requests\Distributors\Products\DeleteRequest;

use App\Http\Resources\Distributors\Products\MasterStoreCollection;
use App\Http\Resources\Distributors\Products\MasterStoreResource;

use App\Http\Resources\Distributors\Products\ProductDetailResource;
use App\Http\Resources\Distributors\Products\ProductDetailsCollection;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


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


    public function update($id,UpdateMasterStoreRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $product = MasterStore::where('store_id',auth()->user()->myStore->id)->whereId($id)->first();
            if (empty($product)) {
                        return $this->errorStatus(__('msg.errorNotFound'));
                    }
            $product->update([
                'description'=>$request->description,
                'retail_price'=>$request->retail_price,
                'lastEditBy_id'=>Auth::user()->id
            ]);


            return $this->respondWithItem(new MasterStoreResource($product) );

        }


    }

    public function destroy($id, DeleteRequest $request)
    {
        if (!Hash::check($request->current_password, Auth::user()->password)) {
            return $this->errorStatus(__('msg.checkPassword'));

        }else{
            $product = MasterStore::withTrashed()->where('store_id',auth()->user()->myStore->id)->whereId($id)->first();
                if ($product->trashed()) {
                    // The record is soft deleted
                    return $this->errorStatus(__('msg.theRecordAlreadyDeleted'));
                }
            $product->delete();
            return $this->respondWithMessage(__('msg.deleted'));

        }

    }

    



}
