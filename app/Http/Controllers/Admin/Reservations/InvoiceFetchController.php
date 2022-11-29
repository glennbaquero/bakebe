<?php

namespace App\Http\Controllers\Admin\Reservations;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Invoices\Invoice;

use Carbon\Carbon;

class InvoiceFetchController extends Controller
{
    /**
     * Set object class of fetched data
     * 
     * @return void
     */
    public function setObjectClass()
    {
        $this->class = new Invoice;
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
        if($this->request->filled('branch_id')) {
            $query = $query->where('branch_id', $this->request->branch_id);
        }

        if($this->request->filled('payment_status')) {
            $query = $query->where('is_paid', $this->request->payment_status);
        }

        if($this->request->filled('payment_type')) {
            $query = $query->where('payment_type', $this->request->payment_type);
        }


      
        return $query;
    }

    /**
     * Modified via FetchController
     *  Fetch data via date range
     *
     * @return array
     */
    // protected function dateQuery($query) {
    //    if($this->request->start_date && $this->request->end_date) {
    //        $query = $query->whereHas('cart.cartItems', function($query) {
    //            $query->whereBetween('scheduled_date', [$this->request->start_date, $this->request->end_date]);
    //        });
    //    }

    //     return $query;
    // }

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
        	if(!$item->is_paid) {
        		foreach ($item->cart->cartItems as $cartItem) {
        			$data = $this->formatItem($item);
        			$data = array_merge($data, [
        			    'id' => $item->id,
        			    'reference_number' => $item->reference_number,
        			    'user' => $item->user->renderName(),
        			    'payment_type_label' => $item->renderPaymentTypeLabel(),
        			    'payment_type_class' => $item->renderPaymentTypeClass(),
        			    'payment_status_label' => $item->renderPaymentStatusLabel(),
        			    'payment_status_class' => $item->renderPaymentStatusClass(),
                        'attendees' => $cartItem->attendees,
        			    'branch' => $item->cart->branch->name,
        			    'scheduled_date' => $cartItem->formatted_schedule,
        			    'start_time' => $cartItem->getReservationTime(),
        			    'grand_total' => $cartItem->grand_total,
        			    'sub_total' => $cartItem->sub_total,
                        'price_per_head' => $cartItem->price_per_head,
                        'additional_fee' => $cartItem->additional_fee,
        			    'invoice_grand_total' => $item->total_payment,
        			    'pastry' => $cartItem->pastry->name,
        			    'created_at' => $item->renderDate(),
        			    'deleted_at' => $item->deleted_at,
                        'email' => $item->user->email,
                        'contact_number' => $item->user->mobile_number,
                        'is_claimed' => 'Invoice not paid',
                        'is_claim' => 'Invoice not paid',
        			]);
        			array_push($result, $data);
        		}
        	} else {
        		foreach ($item->invoiceItems as $invoiceItem) {
        			$data = $this->formatItem($item);
        			$data = array_merge($data, [
        			    'id' => $item->id,
        			    'reference_number' => $item->reference_number,
        			    'user' => $item->user->renderName(),
        			    'payment_type_label' => $item->renderPaymentTypeLabel(),
        			    'payment_type_class' => $item->renderPaymentTypeClass(),
        			    'payment_status_label' => $item->renderPaymentStatusLabel(),
        			    'payment_status_class' => $item->renderPaymentStatusClass(),
        			    'attendees' => $invoiceItem->attendees,
        			    'scheduled_date' => $invoiceItem->formatted_schedule,
        			    'start_time' => $invoiceItem->getReservationTime(),
        			    'grand_total' => $invoiceItem->grand_total,
                        'sub_total' => $invoiceItem->sub_total,
                        'price_per_head' => $invoiceItem->price_per_head,
        			    'additional_fee' => $invoiceItem->additional_fee,
        			    'invoice_grand_total' => $item->total_payment,
        			    'pastry' => json_decode($invoiceItem->pastry_data)->name,
        			    'created_at' => $item->renderDate(),
        			    'deleted_at' => $item->deleted_at,
                        'branch' => $item->cart->branch->name,
                        'email' => $item->user->email,
                        'contact_number' => $item->user->mobile_number,
                        'is_claimed' => $invoiceItem->is_claim ? true : false,
                        'is_claim' => $invoiceItem->is_claim ? 'Claimed' : 'Unclaimed',
        			]);

        			array_push($result, $data);
        		}
        	}
        	
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

        $ovt = '---';

        if($item->couponUsage) {
            $discount_type = $item->couponUsage->coupon->discount_type;

            if($discount_type == 0)
            {
                $discount = $item->couponUsage->coupon->discount;
                $discount = $discount / 100;
                $ovt = $discount;
            }
            else{
                $discount = $item->couponUsage->coupon->discount;
                $ovt = $discount;
            }
        }
        return [
            'ovt' => $ovt,
            'booking_type' => $item->cart->bookingType->name,
            'coupon_code' => $item->couponUsage ? $item->couponUsage->coupon->code : '---',
            'showUrl' => $item->renderShowUrl(),
            'markAsClaimed' => $item->renderInvoiceClaimed(),
        ];
    }

    public function fetchView($id = null)
    {
        $item = null;

        if ($id) {
            $ovt = '---';

            $item = Invoice::find($id);

            if($item->couponUsage) {
                $discount_type = $item->couponUsage->coupon->discount_type;

                if($discount_type == 0)
                {
                    $discount = $item->couponUsage->coupon->discount;
                    $discount = $discount / 100;
                    $ovt = $discount;
                }
                else{
                    $discount = $item->couponUsage->coupon->discount;
                    $ovt = $discount;
                }
            }

            $item->discount = '₱ '.number_format($item->cart->renderTotalDiscount() + $item->discount_price, 2, '.', ',');
            $item->name = $item->user->renderName();
            $item->email = $item->user->email;
            $item->mobile_number = $item->user->mobile_number;
            $item->formatted_payment = '₱ '.number_format($item->total_payment, 2, '.', ',');
            $item->payment_type_label = $item->renderPaymentTypeLabel();
            $item->payment_type_class = $item->renderPaymentTypeClass();
            $item->payment_status_label = $item->renderPaymentStatusLabel();
            $item->payment_status_class = $item->renderPaymentStatusClass();
            $item->branch = $item->cart->branch->name;
            $item->items = $item->is_paid ? $this->fetchData($item->invoiceItems, 'invoice_items') : $this->fetchData($item->cart->cartItems); 
            $item->code = $item->couponUsage ? $item->couponUsage->coupon->code : '---';
            $item->discount_code = $ovt;
            $item->booking_type = $item->cart->bookingType->name;
        }

        return response()->json([
            'item' => $item,
        ]);
    }

    public function fetchData($items, $table='cart_items') {
        $result = [];
        foreach ($items as $item) {
            array_push($result, [
                'attendees' => $item->attendees,
                'id' => $item->id,
                'scheduled_date' => $item->formatted_schedule,
                'start_time' => $item->getReservationTime(),
                'grand_total' =>'₱ '.number_format($item->grand_total, 2, '.', ','),
                'sub_total' => '₱ '.number_format($item->sub_total, 2, '.', ','),
                'pastry' => $table != 'cart_items' ? json_decode($item->pastry_data)->name : $item->pastry->name,
                'claimedUrl' => $table != 'cart_items' ? $item->renderMarkAsClaimedUrl() : null,
                'show_claim' => $table != 'cart_items' ? true : false,
                'is_claimed' => $table != 'cart_items' ? ($item->is_claim ? true : false) : false,
                'claim_status' => $table != 'cart_items' ? $item->renderClaimedStatus() : 'Invoice not paid'
            ]);
        }

        return $result;
    }
}
