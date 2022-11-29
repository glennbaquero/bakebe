<?php

namespace App\Http\Controllers\Admin\CouponUsages;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Coupons\CouponUsage;
use App\Models\Coupons\Coupon;
use App\Models\Users\User;
use App\Models\Invoices\Invoice;

use DB;
use Carbon\Carbon;

class CouponUsageFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new CouponUsage;
    }

    /**
     * Custom filtering of query
     * 
     * @param Illuminate\Support\Facades\DB $query
     * @return Illuminate\Support\Facades\DB $query
     */
    public function filterQuery($query)
    {
        /**
         * Queries
         * 
         */

        return $query;
    }

    /**
     * Custom formatting of data
     * 
     * @param Illuminate\Support\Collection $items
     * @return array $result
     */ 
    public function formatData($items)
    {
        $result = [];

        foreach($items as $item) {

            $data = $this->formatItem($item);
            array_push($result, $data);
        }

        return $result;
    }

    /**
     * Build array data
     * 
     * @param  App\Contracts\AvailablePosition
     * @return array
     */
    protected function formatItem($item)
    {
        $discount = 0;
        $tot_p = 0;
        $ovt = 0;
        $discount_type = $item->coupon->discount_type;

        if($discount_type == 0)
        {
            $discount = $item->coupon->discount;
            $discount = $discount / 100;
            $tot_p = $item->invoice['total_payment'];
            
            $ovt = $tot_p * $discount;
        }
        else{
            $discount = $item->coupon->discount;
            $tot_p = $item->invoice->total_payment;
            $ovt = $tot_p - $discount;

        }
        $total_payment = $item->invoice->total_payment + $discount;
        return [

            'id' => $item->id,
            'fullname' => $item->user->renderFullname(),
            'code' => $item->coupon->code,

            'reference_number' => $item->invoice->reference_number,
            'total_payment' => '₱ '.number_format((float)$total_payment, 2, '.', ','),
            'ovt' => '₱ ' .number_format((float)$ovt+$discount, 2, '.', ','),
            'discount' => '₱ ' .number_format((float)$discount, 2, '.', ''),

            'showUrl' => $item->renderShowUrl(),

        ];
    }

    public function fetchView($id = null)
    {
        $item = null;
        if ($id) {
            $item = CouponUsage::withTrashed()->findOrFail($id);
            $item = $this->formatView($item);

        }

        return response()->json([
            'item' => $item,

        ]);
    }
}
