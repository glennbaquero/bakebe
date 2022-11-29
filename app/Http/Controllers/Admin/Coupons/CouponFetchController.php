<?php

namespace App\Http\Controllers\Admin\Coupons;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Coupons\Coupon;
use App\Models\Promos\PromoCategory;

class CouponFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Coupon;
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
            $data = array_merge($data, [
                'id' => $item->id,
                'name' => $item->name,
                'code' => $item->code,
                'discount' => $item->renderDiscountWithPercentageLabel(),
                'type_label' => $item->renderDiscountTypeLabel(),
                'type_class' => $item->renderDiscountTypeClass(),
                'max_usage' => $item->max_usage,
                'max_user' => $item->max_user,
                'valid_start_at' => $item->formatted_date_start,
                'valid_end_at' => $item->formatted_date_end,
                'status_label' => $item->renderStatusLabel(),
                'status_class' => $item->renderStatusClass(),
                'created_at' => $item->renderDate(),
                'deleted_at' => $item->deleted_at,
            ]);

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
        return [
            'showUrl' => $item->renderShowUrl(),
            'archiveUrl' => $item->renderArchiveUrl(),
            'restoreUrl' => $item->renderRestoreUrl(),
        ];
    }

    public function fetchView($id = null)
    {
        $item = null;
        $types = Coupon::getDiscountType();
        $voucher_types = Coupon::getVoucherType();
        // $promos = Coupon::getPromoType();
        $promos = PromoCategory::all();
        if ($id) {
            $item = Coupon::withTrashed()->findOrFail($id);
            $item->category_ids = $item->promoCategories()->pluck('id')->toArray();
            $item = $this->formatView($item);
        }

        return response()->json([
            'item' => $item,
            'types' => $types,
            'voucher_types' => $voucher_types,
            'promos' => $promos,
        ]);
    }

    protected function formatView($item)
    {
        $item->is_voucher = $item->is_voucher ? true : false;
        $item->archiveUrl = $item->renderArchiveUrl();
        $item->restoreUrl = $item->renderRestoreUrl();

        return $item;
    }
}
