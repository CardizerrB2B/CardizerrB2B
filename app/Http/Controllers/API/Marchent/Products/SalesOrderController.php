<?php

namespace App\Http\Controllers\API\Marchent\Products;

use App\Http\Controllers\ApiController;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


use App\Models\SalesOrder;
use App\Models\SalesOrderDetail;
use App\Models\Store;
use App\Models\MasterStore;
use App\Models\StoreItem;

use App\Http\Requests\Marchents\SalesOrders\StoreSalesOrderRequest;

use App\Http\Resources\Marchents\SalesOrders\SalesOrderDetailResource;
use App\Http\Resources\Marchents\SalesOrders\SalesOrderDetailsCollection;
use App\Http\Resources\Marchents\SalesOrders\SalesOrderResource;
use App\Http\Resources\Marchents\SalesOrders\SalesOrdersCollection;

class SalesOrderController extends ApiController
{
    public function getSalesOrders()
    {
		$salesOrders = SalesOrder::where('marchent_id',auth()->user()->id)->paginate(20);

		if(!$salesOrders->count() > 0)
        {
			return $this->errorNotFound();
        }

		return new SalesOrdersCollection($salesOrders);
    }

    public function show($id)
    {
		$salesOrder = SalesOrder::find($id);
		if (!$salesOrder) {
            return $this->errorNotFound();
        }

		return $this->respondWithItem(new SalesOrderResource($salesOrder));
    }

    public function store(StoreSalesOrderRequest $request)
    {
        try {
            DB::beginTransaction();
		
			$total = 0;

            foreach ($request->items as $item) {
				$item = MasterStore::whereId($item['master_store_id'])->first();
				if (!$item) {
					throw new Exception(__('msg.errorNotFound'));
				}
				$total += $item->retail_price ;
			}

			$salesOrder = SalesOrder::create([
				'distributor_id' => $item->distributor_id,
				'marchent_id' => Auth::id(),
				'store_id' => $item->store_id,
				'total' => $total,
			]);

			foreach ($request->items as $item) {
				$store_item_id=$item['store_item_id'];
				$product_secure_type_id=$item['product_secure_type_id'];

                $item = MasterStore::whereId($item['master_store_id'])->first();
				if (!$item) {
					throw new Exception(__('msg.errorNotFound'));
				}
				$store_item = StoreItem::find($store_item_id);
				if (!$store_item) {
					throw new Exception(__('msg.errorNotFound'));
				}

                SalesOrderDetail::create([
                    'SO_id'=>$salesOrder->id,
					'store_item_id'=>$store_item_id,
                    'master_store_id'=>$item->id,
                    'item_code'=>$item->item_code,
					'product_secure_type_id'=>$product_secure_type_id,
                    'product_secure_type_value'=>$store_item->product_secure_type_value,
                    'item_price'=>$item->retail_price,
                ]);

				$store_item->update([
					'sales_order_id'=>$salesOrder->id,
					'marchent_id'=>$salesOrder->marchent_id,
					'isSold'=>1,
					'sold_date'=>now(),

				]);

				$item->update([
					'QTY' => $item->QTY - 1
				]);
			}

            $salesOrder->refresh();

			DB::commit();

            return $this->successStatus((__('msg.successStatus'))); 

        }  catch (\Exception $exception) {
			DB::rollback();
			return $this->errorStatus(__($exception->getMessage()));

        }

    }

    public function canceleOrder($id)
    {
		$salesOrder = SalesOrder::whereId($id)
										->where('status','created')	
										->where('is_invoiced',0)
										->where('is_credit',0)->first();

	    if (!$salesOrder) {
            return $this->errorNotFound();
        }
		$salesOrder->update([
			'status' => 'canceled'
		]);
		return $this->successStatus((__('msg.successStatus'))); 


    }




	public function mySalesOrderDetails($so)
	{
		$salesOrderDetails = SalesOrderDetail::where('SO_id',$so)->paginate(20);

		if(!$salesOrderDetails->count() > 0)
        {
			return $this->errorNotFound();
        }

		return new SalesOrderDetailsCollection($salesOrderDetails);
	}

	public function showMySalesOrderDetail($so,$id)
	{
		$salesOrderDetail = SalesOrderDetail::where('SO_id',$so)->whereId($id)->first();
		
		if (!$salesOrderDetail) {
            return $this->errorNotFound();
        }

		return $this->respondWithItem(new SalesOrderDetailResource($salesOrderDetail));

	}

    
}
