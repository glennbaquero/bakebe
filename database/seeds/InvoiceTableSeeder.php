<?php

use Illuminate\Database\Seeder;

use App\Models\Carts\Cart;
use App\Models\Carts\CartItem;
use App\Models\Invoices\Invoice;
use App\Models\Invoices\InvoiceItem;

class InvoiceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	Cart::truncate();
    	CartItem::truncate();
    	Invoice::truncate();
    	InvoiceItem::truncate();

        $this->cartSeeder();
        $this->cartItemSeeder();
        $this->invoiceSeeer();
        $this->invoiceItemSeeer();
    }

    public function cartSeeder() {
    	$cartRow = 0;
        
        if(($handle = fopen('database/csv/carts.csv', "r")) !== FALSE){
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $this->command->info('writing carts ' . $cartRow . ' ' . $data[0]);

                $item = new Cart();
                $item->user_id = $data[0];
                $item->booking_type_id = $data[1];
                $item->branch_id = $data[2];
                $item->promo_id = $data[3];
                $item->grand_total = $data[4];
                $item->is_active = $data[5];

                $item->save();

                $cartRow++;

            }
            fclose($handle);
        }
    }

    public function cartItemSeeder() {
    	$cartItemRow = 0;
    	
    	if(($handle = fopen('database/csv/cart_items.csv', "r")) !== FALSE){
    		while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

    	        $this->command->info('writing cart items ' . $cartItemRow . ' ' . $data[0]);

    	        $item = new CartItem();
    	        $item->cart_id = $data[0];
    	        // $item->promo_id = $data[1];
    	        $item->pastry_id = $data[1];
    	        $item->attendees = $data[2];
    	        $item->price_per_head = $data[3];
    	        $item->additional_fee = $data[4];
    	        $item->sub_total = $data[5];
    	        $item->grand_total = $data[6];
    	        $item->scheduled_date = $data[7];
                $item->start_time = $data[8];
    	        // $item->booking_type_id = $data[10];

    	        $item->save();

    	        $cartItemRow++;

    	    }
    	    fclose($handle);
    	}
    }

    public function invoiceSeeer() {
    	$invoiceRow = 0;
        
        if(($handle = fopen('database/csv/invoices.csv', "r")) !== FALSE){
        	while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {

                $this->command->info('writing invoices ' . $invoiceRow . ' ' . $data[0]);

                $item = new Invoice();
                $item->cart_id = $data[0];
                $item->user_id = $data[1];
                $item->total_payment = $data[2];
                $item->reference_number = $data[3];
                $item->payment_type = $data[4];
                $item->payment_code = $data[5];
                $item->status = $data[6];
                $item->is_paid = $data[7];

                $item->save();

                $invoiceRow++;

            }
            fclose($handle);
        }
    }

    public function invoiceItemSeeer() {
    	$cart = Cart::first();
    	$invoice = Invoice::first();

    	foreach ($cart->cartItems as $item) {
    		$this->command->info('writing invoice item row ');

    		$invoice->invoiceItems()->create([
	    		'pastry_data' => json_encode($item->pastry),
	    		'cart_item_data' => json_encode($item),
	    		'promo_data' => json_encode($cart->promo),
                'attendees' => $item->attendees,
	    		'branch_id' => $cart->branch_id,
	    		'price_per_head' => $item->price_per_head,
	    		'additional_fee' => $item->additional_fee,
	    		'sub_total' => $item->sub_total,
	    		'grand_total' => $item->grand_total,
	    		'scheduled_date' => $item->scheduled_date,
	    		'start_time' => $item->start_time,
	    	]);
    	}
    }
}
