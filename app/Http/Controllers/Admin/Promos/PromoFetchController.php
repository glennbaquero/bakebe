<?php

namespace App\Http\Controllers\Admin\Promos;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Promos\Promo;
use App\Models\Promos\PromoCategory;

class PromoFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Promo;
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
                'category' => $item->promoCategory->name,
                // 'rate' => $item->rate,
                // 'additional_fee' => $item->additional_fee,
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
        $categories = PromoCategory::all();
        $types = Promo::getDiscountType();

        if ($id) {
            $item = Promo::withTrashed()->findOrFail($id);
            $item = $this->formatView($item);
        }

        return response()->json([
            'item' => $item,
            'categories' => $categories,
            'types' => $types
        ]);
    }

    protected function formatView($item)
    {
        $item->archiveUrl = $item->renderArchiveUrl();
        $item->restoreUrl = $item->renderRestoreUrl();
        $item->path = $item->renderImagePath();

        return $item;
    }
}
