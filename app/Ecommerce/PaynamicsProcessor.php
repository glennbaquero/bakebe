<?php

namespace App\Ecommerce;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\Users\Admin;
use App\Models\Invoices\Invoice;
use App\Models\Pages\PageItem;

use App\Notifications\Admin\Reservation\AdminReservationPaid;
use App\Notifications\Web\Reservation\UserReservationPaid;

use Auth;

class PaynamicsProcessor 
{

	protected $merchantKey;
	protected $merchantID;
	protected $invoice;

	public function __construct()
	{	
		$this->merchantID = config('ecommerce.paynamics.merchantid');
		$this->merchantKey = config('ecommerce.paynamics.merchantkey');

	}


	/**
	 * Create xml
	 * 
	 * @param  $invoice
	 * 
	 */
	public function createXML($invoice)
	{

		Log::info('Creating XML...');

		$this->invoice = $invoice;

		$_mid = $this->merchantID;
		$_requestid = $this->invoice->reference_number;

		$_fname = $this->invoice->user->first_name;
		$_mname = '';
		$_lname = $this->invoice->user->last_name;
		$_addr1 = $this->invoice->cart->branch->location;
		$_addr2 = $this->invoice->cart->branch->location;
		$_city = null;
		$_state = null;
		$_country = 'Philippines';
		$_zip = null;
		$_email = $this->invoice->user->email;
		$_phone = $this->invoice->user->mobile_number;
		$_mobile = $this->invoice->user->mobile_number;
		$_ipaddress = config('ecommerce.paynamics.ipaddress');
		$_noturl = route('web.paynamics.process_paynamics'); // url where response is posted
		$_resurl = route('web.paynamics.paynamics_return'); //url of merchant landing page
		$_cancelurl = route('web.paynamics.paynamics-cancel');		
		$_clientip = $_SERVER['REMOTE_ADDR'];
		$_sec3d = "try3d";
		$_amount = number_format($this->invoice->total_payment, 2, '.', ''); // kindly set this to the total amount of the transaction. Set the amount to 2 decimal point before generating signature.
		$_currency = "PHP"; //PHP or USD

		$forSign = $_mid . $_requestid . $_ipaddress . $_noturl . $_resurl . $_fname . $_lname . $_addr1 . $_city . $_state . $_country . $_zip . $_email . $_phone . $_clientip . $_amount . $_currency . $_sec3d;


		$cert =  $this->merchantKey; //<-- your merchant key
        $_sign = hash("sha512", $forSign . $cert);		

        Log::info('Paynamics Signature: ' . $_sign);


		$strxml = "";
		$strxml = $strxml . "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
		$strxml = $strxml . "<Request>";
		$strxml = $strxml . "<orders>";
		$strxml = $strxml . "<items>";
		
		// foreach ($invoice->cart->cartItems as $item) {

			$strxml = $strxml . "<Items>";
				$strxml = $strxml . "<itemname>BakeBe Reservation</itemname><quantity>". 1 ."</quantity><amount>" . number_format($this->invoice->total_payment, 2, '.', '') . "</amount>";		
			$strxml = $strxml . "</Items>";
			// Log::info('Cart Item : ' . $item->pastry->name);
		// }

		$strxml = $strxml . "</items>";
		$strxml = $strxml . "</orders>";
		$strxml = $strxml . "<mid>" . $_mid . "</mid>";
		$strxml = $strxml . "<request_id>" . $_requestid . "</request_id>";
		$strxml = $strxml . "<ip_address>" . $_ipaddress . "</ip_address>";
		$strxml = $strxml . "<notification_url>" . $_noturl . "</notification_url>";
		$strxml = $strxml . "<response_url>" . $_resurl . "</response_url>";
		$strxml = $strxml . "<cancel_url>" . $_cancelurl . "</cancel_url>";
		$strxml = $strxml . "<mtac_url></mtac_url>"; // pls set this to the url where your terms and conditions are hosted
		$strxml = $strxml . "<descriptor_note>VISITA Reservation</descriptor_note>"; // pls set this to the descriptor of the merchant ""
		$strxml = $strxml . "<fname>" . $_fname . "</fname>";
		$strxml = $strxml . "<lname>" . $_lname . "</lname>";
		$strxml = $strxml . "<address1>" . $_addr1 . "</address1>";
		$strxml = $strxml . "<city>" . $_city . "</city>";
		$strxml = $strxml . "<state>" . $_city . "</state>";
		$strxml = $strxml . "<country>" . $_country . "</country>";
		$strxml = $strxml . "<zip>" . $_zip . "</zip>";
		$strxml = $strxml . "<secure3d>" . $_sec3d . "</secure3d>";
		$strxml = $strxml . "<trxtype>sale</trxtype>";
		$strxml = $strxml . "<email>" . $_email . "</email>";
		$strxml = $strxml . "<phone>" . $_phone . "</phone>";
		$strxml = $strxml . "<mobile>" . $_mobile . "</mobile>";
		$strxml = $strxml . "<client_ip>" . $_clientip . "</client_ip>";
		$strxml = $strxml . "<amount>" . $_amount . "</amount>";
		$strxml = $strxml . "<currency>" . $_currency . "</currency>";
		$strxml = $strxml . "<mlogo_url>https://phbooking.bakebe.com/images/assets/logo.png</mlogo_url>";// pls set this to the url where your logo is hosted
		$strxml = $strxml . "<pmethod></pmethod>";
		$strxml = $strxml . "<signature>" . $_sign . "</signature>";
		$strxml = $strxml . "</Request>";

        Log::info('XML : ' .  $strxml);

        Log::info('Encoding xml to base64');

        $b64string =  base64_encode($strxml);

        Log::info('XML encoded to base64: ' .  $b64string);

        return $b64string;

	}


	/**
	 * Process paynamics
	 * 
	 */
	public function process($request)
	{
        Log::info('Proccessing transaction...');

        $body = $request->paymentresponse;
        Log::info('PAYMENT RESPONSE: ' . $body);        

        $base64 = str_replace(" ", "+", $body);
        Log::info('Base64: ' . $base64);

        $body = $base64 . '+';
        
        Log::info('Modified Body: ' . $body);
        
        $body = base64_decode($body); // this will be the actual xml

        try {
            $data = new \SimpleXMLElement($body);
        } catch (\Exception $e) {
            $body = base64_decode($base64);
            $data = new \SimpleXMLElement($body);
        }

        Log::info('RECEIVED DATA: ' . $body);
        Log::info('RECEIVED CODE: ' . $data->responseStatus->response_code);        

        $reference_code = $data->application->request_id;

        /** Find invoice */
        $query = [
            'is_paid' => false,
            'status' => 0,
            'reference_number' => $reference_code,
        ];

        $this->invoice = Invoice::where($query)->first();


        if($this->invoice) {
        	if($data->responseStatus->response_code == 'GR001' || $data->responseStatus->response_code == 'GR002') {
	            Log::info('GR001 or GR002');

                $forSign = $data->application->merchantid . $data->application->request_id . $data->application->response_id . $data->responseStatus->response_code . $data->responseStatus->response_message . $data->responseStatus->response_advise . $data->application->timestamp . $data->application->rebill_id;
                $cert = $this->merchantKey; //<-- your merchant key
                $_sign = hash("sha512", $forSign . $cert);

                Log::info('signedXMLResponse: ' . $data->application->signature);
                Log::info('Signature: ' . $_sign);

                /** Begin transaction */
                \DB::beginTransaction();

                	$branch_id = $this->invoice->cart->branch_id;
					
					/** Update payment status to PAID */
                	$this->invoice->is_paid = true;
                	$this->invoice->status = 1;
                	$this->invoice->payment_code = $data->responseStatus->response_code;
			        $this->invoice->branch_id = $branch_id;

                	$this->invoice->save();

                	$cartItems = $this->invoice->cart->cartItems;
                	
                	foreach ($cartItems as $cartItem) {
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
                			'branch_id' => $this->invoice->cart->branch->id,
			                'with_two_attendees' => $cartItem->with_two_attendees,
			                'is_one_pastry_per_person' => $cartItem->is_one_pastry_per_person
                		]);
                	}

				/** End transaction */
				\DB::commit();

			    /**
			     * Send Email via user and admin 
			     */
			    
			    $admins = Admin::all();

				$terms_condition = PageItem::where('slug', 'checkout_terms_and_condition')->first() ?? null;
			    $this->invoice->user->notify(new UserReservationPaid($this->invoice, 'Paynamics', $terms_condition->content));
			    
			    foreach ($admins as $admin) {
			    	if($admin->hasAnyPermission(['admin.bookings.index', 'admin.bookings.show', 'admin.invoice.mark-claimed', 'admin.invoice-items.mark-as-claimed'])) {
				    	$admin->notify(new AdminReservationPaid($this->invoice, 'Paynamics'));
				    }
			    }

				/**
				 * @todo
				 *
				 * Create a notification for success payment
				 */
                
                Log::info('Transaction done..');		

        	} else if($data->responseStatus->response_code == 'GR033') {


				/** Update payment status to PROCESSING */	
            	$this->invoice->payment_code = $data->responseStatus->response_code;            	
            	$this->invoice->save();

            	/** Pending payment */
                Log::info('Transaction Pending...');            	

        	} else if($data->responseStatus->response_code == 'GR053') {

				/** Update payment status to TRANSACTION_CANCELLED */
            	$this->invoice->payment_code = $data->responseStatus->response_code;            	
            	$this->invoice->save();

                Log::info('Transaction Cancelled...');
        	
        	} else {

				/** Update payment status to TRANSACTION_CANCELLED */
            	$this->invoice->payment_code = $data->responseStatus->response_code;            		
				$this->invoice->save();

                Log::info('Transaction Failed.');
                Log::info('Response Code: ' . $data->responseStatus->response_code);
                Log::info('Message: ' . $data->responseStatus->response_message);
                Log::info('Advise: ' . $data->responseStatus->response_advise);

        	}
        }

	}

	/**
	 * Processing paynamics return response
	 * 
	 * @param  $request
	 */
    public function processReturnResponse($request)
    {
        $reference_code = base64_decode($request->requestid);
        Log::info('Reference Code: ' . $reference_code);
        
        $this->invoice = Invoice::where('reference_number', $reference_code)->first();
        Log::info('Invoice: ' . $this->invoice);
        Log::info('Response Code: '. $this->invoice->payment_code);

        if ($this->invoice->payment_code == 'GR001' || $this->invoice->payment_code == 'GR002')
        {
			/**
			 * return for success payment
			 * 
			 */
        }
        // check if pending payment
        else if ($this->invoice->payment_code == 'GR033')
        {
			/**
			 * response for pending payment
			 * 
			 */
        }
        // check if payment was cancelled
        else if ($this->invoice->payment_code == 'GR053')
        {
			/**
			 * response for cancelled payment
			 * 
			 */
        }
        //check if failed payment
        else
        {
			/**
			 * response for failed payment
			 * 
			 */
        }
    }	

}