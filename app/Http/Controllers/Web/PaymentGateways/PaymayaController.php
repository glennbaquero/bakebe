<?php

namespace App\Http\Controllers\Web\PaymentGateways;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;

use App\Ecommerce\PaymayaProcessor;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Checkout;

use App\Models\Invoices\Invoice;
use App\Models\Coupons\Coupon;

use App\Notifications\Admin\Reservation\AdminReservationPaid;
use App\Notifications\Web\Reservation\UserReservationPaid;

use DB;

class PaymayaController extends Controller
{
    public function checkout(Request $request) {
        $user = auth()->guard('web')->user();
        $cart_total =  $user->getCart()->grand_total;

        if($request->voucher != '{}') {
            $voucher_request = json_decode($request->voucher);
            $voucher = Coupon::where('code', $voucher_request->code)->first();
        }


        DB::beginTransaction();

            

        	$invoice = $user->invoices()->create([
                'cart_id' => $user->getCart()->id,
                'total_payment' => $cart_total,
                'reference_number' => Invoice::generateReferenceNumber(),
                'payment_type' => 2,
            ]);

            if($request->voucher != '{}') {
                if($voucher) {
                    if($voucher->getCouponStatus($invoice->total_payment)) {
                        $user->couponUsages()->create([
                            'invoice_id' => $invoice->id,
                            'coupon_id' => $voucher->id
                        ]);
                    } 
                } 
            }

            $user->getCart()->update([
                'is_active' => false
            ]);

        DB::commit();
        
    	$paymaya = new PaymayaProcessor($invoice);

    	return $paymaya->checkout();
    } 

    public function success(Request $request) {
    	return 'success';
    }

    public function failure(Request $request) {
    	return redirect()->route('web.dashboard');
    }

    public function cancel(Request $request) {
    	return 'cancelled';
    }

    public function callback(Request $request) {
        $paymaya = new PaymayaProcessor();
        $callback = $paymaya->callback($request);


        return $callback;
    }

}
