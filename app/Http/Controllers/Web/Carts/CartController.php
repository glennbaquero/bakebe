<?php

namespace App\Http\Controllers\Web\Carts;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Controllers\Web\Carts\CartFetchController;

use App\Models\Invoices\Invoice;
use App\Models\Carts\Cart;
use App\Models\Carts\CartItem;

use DB;

use Auth;

class CartController extends Controller
{
	/**
	 * Creating cart item for logged in user
	 * 
	 * @return [string/boolean] $is_added
	 */
    
    public function createCartItem(Request $request) {
    	$user = auth()->guard('web')->user();
        $cart = $user->getCart();

        $additional_fee = $request->item['attendees'] > 1 ? $request->item['selectedType']['additional_fee'] : 0;
        $rate = $request->item['selectedType']['rate'];
        $price_per_head = $request->item['selectedType']['rate'];

        if($request->item['attendees'] > 1) { 
            if($request->item['is_one_pastry_per_person']) {
                $rate = ($rate * 2) + $request->item['selectedType']['additional_fee'];
            } else {
                $rate *= 2;
            }
        }

        // dd($request->item['selectedType']['rate']);
    	DB::beginTransaction();
            $cart->update([
                'branch_id' => $request->item['branchId'],
                'booking_type_id' => $request->item['typeId'],
                'promo_id' => $item['promoId'] ?? 1,
            ]);

	    	$cart->cartItems()->create([
	    		'pastry_id' => $request->item['pastryId'],
                'attendees' => $request->item['attendees'],
                'price_per_head' => $request->item['selectedType']['rate'],
                'additional_fee' => $additional_fee,
                'sub_total' => $request->item['selectedType']['rate'] * $request->item['attendees'],
                'grand_total' => $request->item['grandTotal'],
                'scheduled_date' => $request->item['dateSelected'],
                'start_time' => $request->item['selectedTime'],
                'with_two_attendees' => $request->item['with_two_attendees'],
                'is_one_pastry_per_person' => $request->item['is_one_pastry_per_person'],
	    	]);

            $cart_grand_total = $request->item['selectedType']['rate'];

            // if($request->item['attendees'] > 1) {
            //     if($request->item['is_one_pastry_per_person']) { 
            //         $cart_grand_total = ($request->item['selectedType']['rate'] * $request->item['attendees']) + $request->item['selectedType']['additional_fee'];
            //     } else {
            //         $cart_grand_total = ($request->item['selectedType']['rate'] * $request->item['attendees']);
            //     }
            // }

            $cart->increment('grand_total', $request->item['grandTotal']);
	    DB::commit();

        $cartFetch = new CartFetchController;

	    return response()->json([
	    	'is_added' => true,
            'cart' => $cartFetch->fetch($request)->original['items'],
            'cartTotal' => $cart->grand_total
	    ]);
    }

    /**
     * Updating the cart item for logged in user
     * 
     * @return [string/boolean] $is_updated 
     */
    
    public function updateCartItem(Request $request, $id) {
    	
    	$item = CartItem::find($id);

    	DB::beginTransaction();
            $additional_fee = 0;
            $sub_total = 0;
            if($request->attendees > 1) {
                $additional_fee = $item->cart->bookingType->additional_fee;
                $sub_total = $item->cart->bookingType->rate * 2;
            }

    		$item->update([
    			'attendees' => $request->attendees,
	    		'scheduled_date' => $request->scheduled_date,
	    		'start_time' => $request->start_time,
	    		'additional_fee' => $additional_fee,
	    		'sub_total' => $sub_total,
	    		'grand_total' => $request->grand_total,
    		]);

            if($request->is_increment) {
                // $item->cart->increment('grand_total', $item->cart->bookingType->rate);
                $item->cart->increment('grand_total', $request->grand_total);
            } else {
                // $item->cart->decrement('grand_total', $item->cart->bookingType->rate);
                $item->cart->decrement('grand_total', $request->grand_total);
            }
    	DB::commit();

    	return response()->json([
	    	'is_updated' => true
	    ]);
    }

    /**
     * Removing the cart item for logged in user
     * 
     * @return [string/boolean] $is_deleted 
     */
    
    public function deleteCartItem(Request $request, $id) {
		$item = CartItem::find($id);
        $additional_fee = $item->attendees > 1 ? $item->cart->bookingType->additional_fee : 0; 
    	DB::beginTransaction();
            $decrement_value = $item->cart->bookingType->rate + $additional_fee;
            $item->cart->decrement('grand_total', $decrement_value);
    		$item->delete();
    	DB::commit();

        $cartFetch = new CartFetchController;

    	return response()->json([
	    	'is_deleted' => true,
            'cart' => $cartFetch->fetch($request)->original['items'],
            'cartTotal' => $item->cart->grand_total
	    ]);
    }

    /**
     * Adding to cart from guest cart to logged in user cart
     * 
     * @return [string/boolean] $is_updated 
     */
    
    public function guestCartToUserCart(Request $request) {
        $user = auth()->guard('web')->user();
        $cart = $user->getCart();
    	DB::beginTransaction();
            if($request->items) {
                foreach ($request->items as $item) {
                    $additional_fee = $item['attendees'] > 1 ? $item['selectedType']['additional_fee'] : 0;
                    $cart->cartItems()->create([
                        'pastry_id' => $item['pastryId'],
                        'attendees' => $item['attendees'],
                        'price_per_head' => $item['selectedType']['rate'],
                        'additional_fee' => $additional_fee,
                        'sub_total' => $item['selectedType']['rate'],
                        'grand_total' => $item['selectedType']['rate'] + $additional_fee,
                        'scheduled_date' => $item['dateSelected'],
                        'start_time' => $item['selectedTime'],
                    ]);
                    $cart->increment('grand_total', $item['selectedType']['rate'] + $additional_fee);
                    $cart->update([
                        'booking_type_id' => $item['typeId'],
                        'branch_id' => $item['branchId'],
                    ]);
                }
            }

            if($request->promoSelected != null && !$cart->promo) {
                $cart->update([
                    'promo_id' => $request->promoSelected['id'],
                ]);    
            }
    		
    	DB::commit();
        
        $cartFetch = new CartFetchController;

    	return response()->json([
    		'is_updated' => true,
            'cart' => $cartFetch->fetch($request)->original['items'],
            'branch' => $cart->branch,
            'type' => $cart->bookingType,
            'cartTotal' => $cart->grand_total
    	]);
    }

    /**
     * Update Cart when user check out
     */
    public function cartUpdate(Request $request) {
        $user = auth()->guard('web')->user();
        $cart = $user->getCart();

        DB::beginTransaction();
            $cart->update([
                'grand_total' => $request->grand_total
            ]);
        DB::commit();

        return response()->json([
            'is_updated' => true
        ]);
    }

    /**
     * Truncate Cart Items from User Cart
     */
    
    public function truncateCartItem(Request $request) {
        $user = auth()->guard('web')->user();
        $cart = $user->getCart();

        DB::beginTransaction();
            $cart->cartItems()->delete();
            $cart->update([
                'grand_total' => 0
            ]);
        DB::commit();

        return response()->json([
            'is_truncated' => true
        ]);
    }
}
