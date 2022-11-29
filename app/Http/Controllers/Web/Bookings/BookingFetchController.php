<?php

namespace App\Http\Controllers\Web\Bookings;

use App\Extenders\Controllers\FetchController as Controller;

use App\Models\Invoices\Invoice;

use App\Models\Invoices\InvoiceItem;

class BookingFetchController extends Controller
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
        
        $user = auth()->guard('web')->user();
        $query = $query->where('user_id', $user->id);
       
        if($this->request->has('is_paid')) {
            if($this->request->is_paid != "2") {
                $query = $query->where('is_paid', $this->request->is_paid);
            }
        }



        if($this->request->has('sortBy')){
            $query = $query->orderBy('created_at', $this->request->sortBy);
        }

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
            if($item->is_paid) {
                foreach ($item->invoiceItems as $invoiceItem) {
                    if(!$this->in_multiarray($item->reference_number, $result, 'reference_number')) {
                        array_push($result, [
                            'id' => $item->id,
                            'user' => $item->user->renderName(),
                            'cart_id' => $item->invoiceItems->count(),
                            'total_payment' => $item->total_payment,
                            'reference_number' => $item->reference_number,
                            'payment_type_label' => $item->renderPaymentTypeLabel(),
                            'payment_type_class' => $item->renderPaymentTypeClass(),
                            'payment_status_label' => $item->renderPaymentStatusLabel(),
                            'payment_status_class' => $item->renderPaymentStatusClass(),
                            'payment_code' => $item->payment_code ? $item->payment_code : 'none',     
                            'is_paid' => $item->is_paid,
                            'coupon_code' => $item->cart->cartItems->first()->coupon_code ?? '---',
                            'created_at' => $item->renderDate(),
                            'showUrl' => $item->renderShowItemUrl(),  
                            'pastry_image' => url('storage/'.json_decode($invoiceItem->pastry_data)->image_path),
                            'pastry' => json_decode($invoiceItem->pastry_data)->name,
                            'difficulty' => json_decode($invoiceItem->pastry_data)->difficulty,
                            'duration' => $item->convertToHoursMins(json_decode($invoiceItem->pastry_data)->duration),
                            'guest' => $invoiceItem->attendees,
                            'scheduled_date' => $invoiceItem->scheduled_date,
                            'start_time' => $invoiceItem->start_time,
                            'invoiceItems' => $item->invoiceItems,
                            'branch' => $item->cart->branch->name,
                            'book_type' => $item->cart->bookingType->name,
                            'printInvoiceUrl' => $item->renderPrintInvoiceUrl()
                        ]);    
                    }
                }
            } else {
                foreach ($item->cart->cartItems as $invoiceItem) {
                    if(!$this->in_multiarray($item->reference_number, $result, 'reference_number')) {
                        array_push($result, [
                            'id' => $item->id,
                            'user' => $item->user->renderName(),
                            'cart_id' => $item->cart->cartItems->count(),
                            'total_payment' => $item->total_payment,
                            'reference_number' => $item->reference_number,
                            'payment_type_label' => $item->renderPaymentTypeLabel(),
                            'payment_type_class' => $item->renderPaymentTypeClass(),
                            'payment_status_label' => $item->renderPaymentStatusLabel(),
                            'payment_status_class' => $item->renderPaymentStatusClass(),
                            'payment_code' => $item->payment_code ? $item->payment_code : 'none',     
                            'is_paid' => $item->is_paid,
                            'coupon_code' => $item->cart->cartItems->first()->coupon_code ?? '---',
                            'created_at' => $item->renderDate(),
                            'showUrl' => $item->renderShowItemUrl(),  
                            'pastry_image' => $invoiceItem->pastry->renderImagePath(),
                            'pastry' => $invoiceItem->pastry->name,
                            'difficulty' => $invoiceItem->pastry->difficulty,
                            'duration' => $item->convertToHoursMins($invoiceItem->pastry->duration),
                            'guest' => $invoiceItem->attendees,
                            'scheduled_date' => $invoiceItem->scheduled_date,
                            'start_time' => $invoiceItem->start_time,
                            'invoiceItems' => $item->cart->cartItems,
                            'branch' => $item->cart->branch->name,
                            'book_type' => $item->cart->bookingType->name,
                        ]);    
                    }
                }
            }
        }

        return $result;
    }  

    public function in_multiarray($elem, $array,$field)
    {
        $top = sizeof($array) - 1;
        $bottom = 0;
        while($bottom <= $top)
        {
            if($array[$bottom][$field] == $elem)
                return true;
            else 
                if(is_array($array[$bottom][$field]))
                    if($this->in_multiarray($elem, ($array[$bottom][$field])))
                        return true;

            $bottom++;
        }        
        return false;
    }  

}

?>
