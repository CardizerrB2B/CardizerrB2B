<?php

namespace App\Http\Requests\Marchents\SalesOrders;

use App\Http\Requests\APIRequest;
class FilterOrderRequest extends APIRequest
{

    public function rules(): array
    {
        return [
            'sort_type' => 'nullable|string|in:ASC,DESC',
            'status'=>'nullable|string|in:created,inProgress,invoiced,delivered,credit,delivered,canceled'
        ];
    }
}
