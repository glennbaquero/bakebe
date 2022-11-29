<?php

namespace App\Http\Controllers\Web\PaymentGateways;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Invoices\Invoice;
use App\Models\Coupons\Coupon;

use DB;

class PaypalController extends Controller
{
    //
    public function checkout(Request $request)
    {
    	$user = auth()->guard("web")->user();
    	$cart = $user->getCart();
        if(count($request->voucher) != 0) {
            $voucher_request = $request->voucher;
            $voucher = Coupon::where('code', $voucher_request['code'])->first();
        }            

    	DB::beginTransaction();
    		$invoice = $user->invoices()->create([
    			'cart_id' => $cart->id,
    			'total_payment' => $cart->grand_total,
    			'payment_type' => 0,
    			'reference_number' => Invoice::generateReferenceNumber(),
    		]);

            if(count($request->voucher) != 0) {
                if($voucher) {
                    if($voucher->getCouponStatus($invoice->total_payment)) {
                        $user->couponUsages()->create([
                            'invoice_id' => $invoice->id,
                            'coupon_id' => $voucher->id
                        ]);
                    } 
                } 
            }

            $cart->update([
                'is_active' => false,
            ]);

    	DB::commit();
    	return response()->json([
    		'reference_number' => $invoice->reference_number,
    		'currency' => 'PHP',
    	]);

    }
}
