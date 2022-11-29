<?php

namespace App\Http\Controllers\Web\Carts;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Carts\Cart;

class CartFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
		$this->request['nopagination'] = 1;
		$this->per_page = 9999999;
        $this->class = new Cart;
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
        $user = auth()->guard('web')->user();
        $cart = $user->carts->where('is_active', true)->first();
        if($cart) {
        	foreach ($cart->cartItems as $item) {
        		
        		array_push($result, [
                    'cartItem_id' => $item->id,
        		    'booking_type' => $item->booking_type_id,
                    'selectedPastry' => $item->getPastryData(),
                    'dateSelected' => $item->scheduled_date,
                    'selectedTime' => $item->start_time,
                    'attendees' => $item->attendees,
                    'totalPayment' => $item->grand_total,
                    'removeItemUrl' => $item->renderRemoveItem(),
                    'updateItemUrl' => $item->renderUpdateItem(),
        		    'created_at' => $cart->created_at,
        		]);

        	}
        }

        return $result;
    }
}
