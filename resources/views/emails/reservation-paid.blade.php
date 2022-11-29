@component('mail::message')

@if($is_user)
 # Hello {{ $invoice->user->renderName() }}!
@else
# Hello {{ $name }}!
@endif

@component('mail::panel')

{{ $panel_message }}

@endcomponent




<p><b>Order Number: {{ $invoice->reference_number }}</b></p>

<p><b>Date of Purchase: {{ $invoice->created_at->toDayDateTimeString() }}</b></p>

<p><b>Discount from Selected Promo: {{ $invoice->cart->renderDiscount() }}</b></p>
<p><b>Discount from Coupon Code: {{ '₱ '.number_format($invoice->cart->renderCouponDiscount(), 2, '.', ',') }}</b></p>
<p><b>Total Reservation: {{ '₱ '.number_format(($invoice->total_payment +  $invoice->cart->renderCouponDiscount() + $invoice->cart->renderTotalDiscount()), 2, '.', ',') }}</b></p>

<p><b>Total Payment: {{ '₱ ' .number_format($invoice->total_payment, 2, '.', ',') }}</b></p>


@component('mail::table')
|                         | Pastry                         | Attendees                      | Schedule                     | Price Per Head                          | Additional Fee                     | Sub Total                    | Total                    |    
|:-------------------------------------:|:-------------------------------------:|:------------------------------:|:------------------------------------:|:------------------------------------:|:------------------------------------:|:------------------------------------:|:------------------------------------:|
@foreach($invoice->invoiceItems as $item)
| <img class="pstry__img" src="{{ $item->getPastryImage($item->renderEncodedPastry()->image_path) }}"> | {{ $item->renderEncodedPastry()->name }} | {{ $item->attendees }} | {{ $item->formatted_schedule }} {{ $item->getReservationTime() }} | {{ $item->renderAmountWithFormat($item->price_per_head) }} | {{ $item->renderAmountWithFormat($item->additional_fee) }} | {{ $item->renderAmountWithFormat($item->sub_total) }} | {{ $item->renderAmountWithFormat($item->grand_total) }} |
@endforeach
@endcomponent

<p><b>* Note : Additional Fee is for added attendee will apply</b></p>

{!! $terms_condition !!}

Thank you for using {{ config('app.name') }}

	
Regards,<br>
{{ config('app.name') }}
@endcomponent

<style>
	.pstry__img {
		width: 70px;
	}
</style>