<?php

namespace App\Http\Controllers\API\Distributor\Products;

use App\Http\Controllers\ApiController;

use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;


use App\Http\Resources\Distributors\PurchaseOrders\PurchaseOrderResource;
use App\Http\Resources\Distributors\PurchaseOrders\PurchaseOrdersCollection;

use App\Http\Resources\Distributors\PurchaseOrders\PurchaseOrderDetailResource;
use App\Http\Resources\Distributors\PurchaseOrders\PurchaseOrderDetailsCollection;

class PurchaseOrderController extends ApiController
{
    public function myPurchaseOrders()
    {
		$purchaseOrders = PurchaseOrder::where('distributor_id',auth()->user()->id)->paginate(20);

		if(!$purchaseOrders->count() > 0)
        {
			return $this->errorNotFound();
        }

		return new PurchaseOrdersCollection($purchaseOrders);
    }

    public function showmyPurchaseOrder($id)
    {
		$purchaseOrder = PurchaseOrder::where('distributor_id',auth()->user()->id)->whereId($id)->first();
		if (!$purchaseOrder) {
            return $this->errorNotFound();
        }

		return $this->respondWithItem(new PurchaseOrderResource($purchaseOrder));
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
