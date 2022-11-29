<?php

namespace App\Http\Controllers\Web\PaymentGateways;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Ecommerce\PaynamicsProcessor;

use App\Models\Invoices\Invoice;
use App\Models\Coupons\Coupon;

use DB;

class PaynamicsController extends Controller
{
    /**
    * Generate Paynamics form
    *
    * @param object $invoice
    * @return string $form
    */
    public function generatePaynamicsForm(Request $request)
    {
        $user = auth()->guard('web')->user();
        $cart_total =  $user->getCart()->grand_total;
        if(count($request->voucher) != 0) {
            $voucher_request = $request->voucher;
            $voucher = Coupon::where('code', $voucher_request['code'])->first();
        }            
        // dd($voucher_request['code']);
        // if($voucher_request) {
        //     $voucher = Coupon::where('code', $voucher_request['code'])->first();
        //     if($voucher) {
        //         if($voucher->getCouponStatus()) {
        //             if($voucher->discount_type === 0) {
        //                 $discount = $voucher->discount / 100;
        //                 $cart_total *= $discount; 
        //             } else {
        //                 $discount = $voucher->discount;
        //                 $cart_total -= $discount; 
        //             }
        //         } 
        //     } 

        // }
        
        DB::beginTransaction();

	    	$invoice = $user->invoices()->create([
	            'cart_id' => $user->getCart()->id,
	            'total_payment' => $request->grand_total,
	            'reference_number' => Invoice::generateReferenceNumber(),
	            'payment_type' => 1,
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

	        $user->getCart()->update([
	            'is_active' => false
	        ]);

        DB::commit();

        $paynamics = new PaynamicsProcessor();
        $signature = $paynamics->createXML($invoice);

        return response()->json([
            'signature' => $signature,
            'gateway_url' => config('ecommerce.paynamics.gateway')
        ]);
    }

    /**
     * Processing paynamics
     * 
     * @param  Requests $request 
     */
    public function processPaynamics(Request $request)
    {
        $processor = new PaynamicsProcessor();

        /** Process Paynamics */
        return $processor->process($request);
    }

    /**
     * Paynamics success return
     * 
     */
    public function paynamicsReturn(Request $request)
    {
        $processor = new PaynamicsProcessor();
        $route = $processor->processReturnResponse($request);

        return redirect()->route('web.dashboard');
    }

    /**
     * Paynamics cancel
     * 
     */
    public function paynamicsCancel()
    {
         return redirect()->route('web.dashboard');
    }
}
