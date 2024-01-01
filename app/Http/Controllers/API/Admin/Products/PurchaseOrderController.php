<?php

namespace App\Http\Controllers\API\Admin\Products;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\MasterFile;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Store;
use App\Models\MasterStore;
use App\Models\StoreItem;

use App\Http\Requests\Admins\PurchaseOrders\StorePurchaseOrderRequest;

use App\Http\Resources\Admins\PurchaseOrders\PurchaseOrderResource;
use App\Http\Resources\Admins\PurchaseOrders\PurchaseOrdersCollection;

use App\Http\Resources\Admins\PurchaseOrders\PurchaseOrderDetailResource;
use App\Http\Resources\Admins\PurchaseOrders\PurchaseOrderDetailsCollection;

class PurchaseOrderController extends ApiController
{
    public function getPurchaseOrders()
    {
		$purchaseOrders = PurchaseOrder::paginate(20);

		if(!$purchaseOrders->count() > 0)
        {
			return $this->errorNotFound();
        }

		return new PurchaseOrdersCollection($purchaseOrders);
    }

    public function show($id)
    {
		$purchaseOrder = PurchaseOrder::find($id);
		if (!$purchaseOrder) {
            return $this->errorNotFound();
        }

		return $this->respondWithItem(new PurchaseOrderResource($purchaseOrder));
    }

    public function store(StorePurchaseOrderRequest $request)
    {
        try {
            DB::beginTransaction();
		
			$total = 0;

            foreach ($request->items as $item) {
				$QTY = $item['QTY'];
				$item = MasterFile::whereId($item['id'])->first();
				if (!$item) {
					throw new Exception(__('msg.errorNotFound'));
				}
				$total += $item->retail_price * $QTY;
			}

			$purchaseOrder = PurchaseOrder::create([
				'admin_id' => Auth::id(),
				'distributor_id' => $request->distributor_id,
				'total' => $total,
			]);

			foreach ($request->items as $item) {
				$QTY = $item['QTY'];
				$product_secure_type_id=$item['product_secure_type_id'];
                $item = MasterFile::whereId($item['id'])->first();
				if (!$item) {
					throw new Exception(__('msg.errorNotFound'));
				}
				
                PurchaseOrderDetail::create([
                    'PO_id'=>$purchaseOrder->id,
                    'item_id'=>$item['id'],
                    'item_code'=>$item->item_code,
					'product_secure_type_id'=>$product_secure_type_id,
                    'QTY'=>$QTY,
                    'item_price'=>$item->retail_price,
                    'total_price'=>$item->retail_price * $QTY ??0
                ]);
			}

            $purchaseOrder->refresh();

			DB::commit();

            return $this->successStatus((__('msg.successStatus'))); 

        }  catch (\Exception $exception) {
			DB::rollback();
			return $this->errorStatus(__($exception->getMessage()));

        }

    }

    public function canceleOrder($id)
    {
		$purchaseOrder = PurchaseOrder::whereId($id)
										->where('status','created')	
										->where('is_invoiced',0)
										->where('is_credit',0)->first();

	    if (!$purchaseOrder) {
            return $this->errorNotFound();
        }
		$purchaseOrder->update([
			'status' => 'canceled'
		]);
		return $this->successStatus((__('msg.successStatus'))); 


    }


	public function confirmOrder($id)
    {
		$purchaseOrder = PurchaseOrder::whereId($id)
										->where('status','created')	
										->where('is_invoiced',0)
										->where('is_credit',0)->first();

	    if (!$purchaseOrder) {
            return $this->errorNotFound();
        }
		$purchaseOrder->update([
			'status' => 'confirmed'
		]);
		return $this->successStatus((__('msg.successStatus'))); 

    }

	public function receiveOrder($id)
    {

		try {
			DB::beginTransaction();

				$purchaseOrder = PurchaseOrder::whereId($id)
												->where('status','confirmed')	
												->where('is_invoiced',0)
												->where('is_credit',0)->first();

				if (!$purchaseOrder) {
					return $this->errorNotFound();
				}
				$purchaseOrder->update([
					'status' => 'received'
				]);

				###### set purchase detail into distributor store ######
				$purchaseOrderDetails=PurchaseOrderDetail::where('PO_id',$purchaseOrder->id)->get();

				if($purchaseOrderDetails->count() == 0)
				{
					return $this->errorStatus((__('msg.POwithoutItems'))); 
				}

				// $store = Store::where('owner_id',$purchaseOrder->distributor_id)->first();

				// if(!$store)
				// {
				// 	return $this->errorStatus((__('msg.storeNotFound'))); 
				// }

				foreach ($purchaseOrderDetails as $purchaseOrderDetail ) {

					$item = MasterFile::find($purchaseOrderDetail->item_id);
					$masterStore=MasterStore::create([
						'store_id'=>getStoreID($purchaseOrder->distributor_id),
						'distributor_id'=>$purchaseOrder->distributor_id,
						'sub_category_id' => $item->sub_category_id,
						'product_secure_type_id' => $purchaseOrderDetail->product_secure_type_id,
						'item_id' => $purchaseOrderDetail->item_id,
						'item_code' => $item->item_code,
						'description' => $item->description,
						'QTY' => $purchaseOrderDetail->QTY,
						'last_cost' => $purchaseOrderDetail->item_price,
						'retail_price' => $item->retail_price,
						'createdBy_id'=>auth()->user()->id

					]);
					//fetch QTY into store items to be able added the secure type per every item later and show the movements of product(Tracking) 
					//dd($masterStore->QTY );
					for($i = 0 ; $i < $masterStore->QTY ;$i++)
					{
						StoreItem::create([
							'master_store_id'=> $masterStore->id,
							'PO_id' => $purchaseOrder->id,
						]);
					}
					
				}
				
			DB::commit();
			return $this->successStatus((__('msg.successStatus'))); 
			
		} catch (\Exception $exception) {
			DB::rollBack();
			return $this->errorStatus(__($exception->getMessage()));

		}

    }



	public function myPurchaseOrderDetails($po)
	{
		$purchaseOrderDetails = PurchaseOrderDetail::where('PO_id',$po)->paginate(20);

		if(!$purchaseOrderDetails->count() > 0)
        {
			return $this->errorNotFound();
        }

		return new PurchaseOrderDetailsCollection($purchaseOrderDetails);
	}

	public function showMyPurchaseOrderDetail($po,$id)
	{
		$purchaseOrderDetail = PurchaseOrderDetail::where('PO_id',$po)->whereId($id)->first();
		
		if (!$purchaseOrderDetail) {
            return $this->errorNotFound();
        }

		return $this->respondWithItem(new PurchaseOrderDetailResource($purchaseOrderDetail));

	}

    
}
