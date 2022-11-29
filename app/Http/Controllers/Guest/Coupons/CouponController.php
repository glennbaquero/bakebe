<?php

namespace App\Http\Controllers\Guest\Coupons;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Validation\ValidationException;

use App\Models\Coupons\Coupon;

class CouponController extends Controller
{
    /**
     * Check if voucher is available
     * 
     * @return boolean $is_available
     */
    
    public function verify(Request $request) {
    	$request->validate([
    		'code' => 'required'
    	]);

    	$message = false;

    	$coupon = Coupon::where('code', $request->code)->first();

    	if($coupon) {
    		$message = true;
    	} else {
            throw ValidationException::withMessages([
                'message' => 'Coupon is not found.'
            ]);
        }

    	$data['code'] = $coupon->code;
    	$data['discount'] = $coupon->discount;
    	$data['discount_type'] = $coupon->discount_type;

        if(!$coupon->getCouponStatus($request->invoice_total)) {
            throw ValidationException::withMessages([
                'message' => 'Coupon is not available'
            ]);
        }

    	return response()->json([
    		'is_verified' => $message,
    		'coupon' => $coupon->getCouponStatus($request->invoice_total) ? $data : null,
    	]);
    }

    public function couponDiscount(Request $request) {

        $user = auth()->guard('web')->user();
        $cart = $user->getCart();
        $total_items = $cart->cartItems->sum('grand_total');
        $cart->update(['grand_total' => $total_items]);
        $cart_total = $cart->grand_total;

        $attendees = $cart->cartItems->sum('attendees');

        $promoSelectedDiscount = $request->promoSelected['discount'] * $attendees;

        if($request->promoSelected['is_percentage']) {
            $promoSelectedDiscount = ($request->promoSelected['discount'] * $attendees) / 100;
        }

        if($request->promoSelected['promo_category_id'] == 3) {
            $promoSelectedDiscount = 0;
        }

        $cart->update(['promo_id' => $request->promoSelected['id']]);

        $result = 0;

        if($request->filled('code')) {
            $coupon = Coupon::where('code', $request->code)->first();
            if($coupon) {
                $cart->update(['grand_total' => 0]);
                $is_percentage = $coupon->is_percentage ? true : false;
                switch($coupon->discount_type) {
                    case 0:
                        $response = $coupon->processTotalOff($cart->cartItems, $cart, $is_percentage, $promoSelectedDiscount);
                        break;
                    case 1:
                       $response = $coupon->processTotalOff($cart->cartItems, $cart, $is_percentage, $promoSelectedDiscount);
                        break;
                    case 2: 
                        // $response = $coupon->getDiscountTypeBuy1Take1($cart->cartItems, $cart);
                        break;
                    case 3: 
                        $response = $coupon->getDiscountTypeItemOff($cart->cartItems, $cart, $is_percentage, $promoSelectedDiscount);
                        break;
                    case 4: 
                        $response = $coupon->getDiscountTypeItemOff($cart->cartItems, $cart, $is_percentage, $promoSelectedDiscount);
                        break;
                }
            }
        } else {
            $cart->decrement('grand_total', $promoSelectedDiscount);
            $response['cart_grand_total'] = $cart->grand_total;
            $response['coupon_grand_total'] = 0;
        }
        return response()->json([
            'grand_total' => $response['cart_grand_total'],
            'coupon_total' => $response['coupon_grand_total'],
            'promoSelectedDiscount' => $promoSelectedDiscount,
            'cart' => $cart
        ]);
    }
}
