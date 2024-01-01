<?php

namespace App\Http\Controllers\API\Distributor\Products;

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
    public function allSalesOrders()
    {
		$salesOrders = SalesOrder::where('distributor_id',auth()->user()->id)->paginate(20);

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




	public function salesOrderDetails($so)
	{
		$salesOrderDetails = SalesOrderDetail::where('SO_id',$so)->paginate(20);

		if(!$salesOrderDetails->count() > 0)
        {
			return $this->errorNotFound();
        }

		return new SalesOrderDetailsCollection($salesOrderDetails);
	}

	public function showSalesOrderDetail($so,$id)
	{
		$salesOrderDetail = SalesOrderDetail::where('SO_id',$so)->whereId($id)->first();
		
		if (!$salesOrderDetail) {
            return $this->errorNotFound();
        }

		return $this->respondWithItem(new SalesOrderDetailResource($salesOrderDetail));

	}

    
}
