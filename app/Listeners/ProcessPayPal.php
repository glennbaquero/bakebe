<?php

namespace App\Listeners;

use PRAXXYSEcommerce\PayPal\Events\PayPalNotified;
use Illuminate\Support\Facades\Log;

use App\Models\Invoices\Invoice;
use App\Models\Users\Admin;
use App\Models\Pages\PageItem;

use App\Notifications\Admin\Reservation\AdminReservationPaid;
use App\Notifications\Web\Reservation\UserReservationPaid;

class ProcessPayPal
{

    protected $result;

    /**
     * Handle the event.
     *
     * @param  \PRAXXYSEcommerce\PayPal\Events\PayPalNotified  $event
     * @return void
     */
    
    public function handle(PayPalNotified $event)
    {

        Log::info('Dispatching PayPalNotified...');

        # dd($event->result):
        # [
        #   "reference_code" => "(your invoice reference)",
        #   "transaction_code" => "Transaction code from PayPal",
        # ]
        $this->result = $event->result;

        # PROCESS YOUR ACTIONS HERE:
        
        $this->processInvoice();
         $this->notifyUser();
         $this->notifyAdmin();
    }


    /* * * * * * * * * * * * * * *
     * SAMPLE CODE FOR REFERENCE *
     * * * * * * * * * * * * * * */


    private function processInvoice() {

        \DB::beginTransaction();

        # will cause error if no code is there
        $this->invoice = Invoice::where('reference_number', $this->result['reference_code'])->first();
        $branch_id = $this->invoice->cart->branch_id;
        $this->invoice->status = 1;
        $this->invoice->payment_code = $this->result['transaction_code'];
        $this->invoice->is_paid = true;
        $this->invoice->branch_id = $branch_id;

        $this->invoice->save();

        foreach ($this->invoice->cart->cartItems as $cartItem) {
            $this->invoice->invoiceItems()->create([
                'pastry_data' => json_encode($cartItem->pastry),
                'cart_item_data' => json_encode($cartItem),
                'promo_data' => json_encode($cartItem->promo),
                'attendees' => $cartItem->attendees,
                'price_per_head' => $cartItem->price_per_head,
                'additional_fee' => $cartItem->additional_fee,
                'sub_total' => $cartItem->sub_total,
                'grand_total' => $cartItem->grand_total,
                'scheduled_date' => $cartItem->scheduled_date,
                'start_time' => $cartItem->start_time,
                'branch_id' => $this->invoice->cart->branch_id,
                'with_two_attendees' => $cartItem->with_two_attendees,
                'is_one_pastry_per_person' => $cartItem->is_one_pastry_per_person
            ]);
        }

        \DB::commit();

    }

    private function notifyUser()
    {
        $terms_condition = PageItem::where('slug', 'checkout_terms_and_condition')->first() ?? null;
        $this->invoice->user->notify(new UserReservationPaid($this->invoice, 'Paypal', $terms_condition->content));
    }

    private function notifyAdmin()
    {
        $admins = Admin::all();

        foreach ($admins as $admin) {
            if($admin->hasAnyPermission(['admin.bookings.index', 'admin.bookings.show', 'admin.invoice.mark-claimed', 'admin.invoice-items.mark-as-claimed'])) {
                $admin->notify(new AdminReservationPaid($this->invoice, 'Paypal'));
            }
        }
    }

}