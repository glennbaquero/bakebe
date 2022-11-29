<?php

namespace App\Ecommerce;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use Aceraven777\PayMaya\PayMayaSDK;
use Aceraven777\PayMaya\API\Checkout;
use Aceraven777\PayMaya\Model\Checkout\Item;
use App\Libraries\PayMaya\User as PayMayaUser;
use Aceraven777\PayMaya\Model\Checkout\ItemAmount;
use Aceraven777\PayMaya\Model\Checkout\ItemAmountDetails;
use Aceraven777\PayMaya\API\Webhook;
use Aceraven777\PayMaya\API\Customization;

use App\Models\Invoices\Invoice;
use App\Models\Users\Admin;
use App\Models\Pages\PageItem;

use App\Notifications\Admin\Reservation\AdminReservationPaid;
use App\Notifications\Web\Reservation\UserReservationPaid;

class PaymayaProcessor
{
	private $invoice;
	private $publick_key, $secret_key, $env;

	/**
	 * Getting the configuration
	 */

	public function __construct($invoice = null) {
		Log::info('Constructing Paymaya');
		$this->invoice = $invoice;
		$this->public_key = config('ecommerce.paymaya.public_key');
		$this->secret_key = config('ecommerce.paymaya.secret_key');
		$this->env = config('ecommerce.paymaya.env');

		PayMayaSDK::getInstance()->initCheckout(
		      	$this->public_key,
		        $this->secret_key,
		        $this->env
		    );

		$this->setupWebHooks();
		$this->customizeMerchantPage();
	}

	public function customizeMerchantPage() {
		$shopCustomization = new Customization();
	    $shopCustomization->get();

	    $shopCustomization->logoUrl = url('images/icons/success.png');
	    $shopCustomization->iconUrl = url('images/icons/warning.png');
	    $shopCustomization->appleTouchIconUrl = url('images/icons/warning.png');
	    $shopCustomization->customTitle = 'This is a Test';
	    $shopCustomization->colorScheme = 'black';

	    $shopCustomization->set();
	}

	/*
	 * Setup webhooks 
	 */
	public function setupWebHooks() {
		Log::info('Setup Web Hooks');
		$webhooks = Webhook::retrieve();
	    foreach ($webhooks as $webhook) {
	        $webhook->delete();
	    }

		$successWebhook = new Webhook();
	    $successWebhook->name = Webhook::CHECKOUT_SUCCESS;
	    $successWebhook->callbackUrl = route('web.paymaya.callback-success');
	    $successWebhook->register();

	    $failureWebhook = new Webhook();
	    $failureWebhook->name = Webhook::CHECKOUT_FAILURE;
	    $failureWebhook->callbackUrl = route('web.paymaya.callback-failure');
	    $failureWebhook->register();

	    $dropoutWebhook = new Webhook();
	    $dropoutWebhook->name = Webhook::CHECKOUT_DROPOUT;
	    $dropoutWebhook->callbackUrl = route('web.paymaya.callback-dropout');
	    $dropoutWebhook->register();
	}

	/**
	 * Checkout for paymaya
	 * @return [string] [redirect to paymaya and return to website]
	 */
	public function checkout() {
		Log::info('Checkout Paymaya');
		$reference_number = $this->invoice->reference_number;
		$email = $this->invoice->user->email;
		$mobile_number = $this->invoice->user->mobile_number;
		$total = $this->invoice->total_payment;
		Log::info('1');

		$itemAmountDetails = new ItemAmountDetails();
		$itemAmountDetails->tax = "0.00";
		$itemAmountDetails->subtotal = number_format($total, 2, '.', '');
		$itemAmount = new ItemAmount();
		$itemAmount->currency = "PHP";
		$itemAmount->value = $itemAmountDetails->subtotal;
		$itemAmount->details = $itemAmountDetails;
		Log::info('2');

		$items = [];

		$itemCheckout = new Checkout();

		$user = new PaymayaUser();
		$user->contact->phone = $mobile_number;
		$user->contact->email = $email;

		$itemCheckout->buyer = $user->buyerInfo();
		Log::info('3');
		$item = new Item();
	    $item->name = 'BakeBe Reservation';
	    $item->amount = $itemAmount;
	    $item->totalAmount = $itemAmount;

		$itemCheckout->items = array($item);
		$itemCheckout->totalAmount = $itemAmount;
		$itemCheckout->requestReferenceNumber = $reference_number;
		$itemCheckout->redirectUrl = array(
			"success" => route('web.paymaya.success'),
			"failure" => route('web.paymaya.failure'),
			"cancel" => route('web.paymaya.cancel'),
		);
		Log::info('4');

		if ($itemCheckout->execute() === false) {
	        $error = $itemCheckout::getError();
			Log::info($error);
	        return redirect()->back()->withErrors(['message' => $error]);
	    }
		Log::info('5');

	    if ($itemCheckout->retrieve() === false) {
	        $error = $itemCheckout::getError();
			Log::info($error);
	        return redirect()->back()->withErrors(['message' => $error]);
	    }
		Log::info('6');

	    return redirect()->to($itemCheckout->url);
	}

	/**
	 * Getting the callback of paymaya
	 *
	 * @return [array of objects] $checkout
	 */
	public function callback($request) {
	    $transaction_id = $request->get('id');
        if (! $transaction_id) {
            Log::info('message Transaction Id Missing');
            return ['status' => false, 'message' => 'Transaction Id Missing'];
        }
        
        Log::info('callback 3');
        $itemCheckout = new Checkout();
        $itemCheckout->id = $transaction_id;
        Log::info('Item Checkout : ');
        Log::info('<<===============================>>');
        Log::info(json_encode($itemCheckout));

        $checkout = $itemCheckout->retrieve();
        Log::info('Checkout : ');
        Log::info('<<===============================>>');
        Log::info($checkout);
        if ($checkout === false) {
            $error = $itemCheckout::getError();
            Log::info($error);
            return redirect()->back()->withErrors(['message' => $error['message']]);
        }
        Log::info('callback 4');

        $checkoutStatus = $checkout['paymentStatus'];
        $reference_number = $checkout['requestReferenceNumber'];
        
        $this->processInvoice($reference_number, $checkoutStatus);

        return $checkout;
	}

	/*
	 * Process invoice
	 */
	public function processInvoice($ref_num, $status) {
		$invoice = Invoice::where('reference_number', $ref_num)
						->where('is_paid', false)->first();
		$cartItems = $invoice->cart->cartItems;
		if($status === 'PAYMENT_SUCCESS') {

			foreach ($cartItems as $cartItem) {
				$invoice->invoiceItems()->create([
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
					'branch_id' => $invoice->cart->branch_id,
	                'with_two_attendees' => $cartItem->with_two_attendees,
	                'is_one_pastry_per_person' => $cartItem->is_one_pastry_per_person
				]);
			}

			$admins = Admin::all();

			$terms_condition = PageItem::where('slug', 'checkout_terms_and_condition')->first() ?? null;
		    
		    $invoice->user->notify(new UserReservationPaid($invoice, 'Paymaya', $terms_condition->content));
			
			foreach ($admins as $admin) {
		    	if($admin->hasAnyPermission(['admin.bookings.index', 'admin.bookings.show', 'admin.invoice.mark-claimed', 'admin.invoice-items.mark-as-claimed'])) {
					$admin->notify(new AdminReservationPaid($invoice, 'Paynamics'));
				}
			}



        	$branch_id = $invoice->cart->branch_id;
			$invoice->is_paid = true;
			$invoice->status = 1;
			$invoice->payment_code = $status;
			$invoice->branch_id = $branch_id;
			
			$invoice->save();

			$invoice->cart->is_active = false;
			$invoice->cart->save();
		}

		return $status;
	}
}