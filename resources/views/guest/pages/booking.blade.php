@extends('guest.master')

{{-- @section('meta:title', 'Login') --}}

@section('content')

<div class="frm-cntnr">
	<booking-view 
		:branches="{{ $branches }}"
		:types="{{ $types }}"
		:blocks="{{ $blocks }}"
		fetch-url="{{ route('guest.pastries.fetch') }}"
		fetch-url-invoices="{{ route('guest.blocks.fetch') }}"
		timeslot-url="{{ route('guest.timeslot') }}"
		fullybooked-url="{{ route('guest.fullybooked') }}"
		voucher-checker-url="{{ route('guest.voucher-checker') }}"
		guest-user-cart-url="{{ route('web.cart.guest-user') }}"
		create-item-url="{{ route('web.cart.insert-item') }}"
		cart-fetch-url="{{ route('web.cart.fetch') }}"
		cart-item-truncate-url="{{ route('web.cart-item.truncate') }}"
		paymaya-url="{{ route('web.paymaya.checkout') }}"
		paynamics-url="{{ route('web.paynamics.generate-form') }}"
		paypal-url="{{ route('web.paypal.checkout') }}"
		authenticated="{{ auth()->guard('web')->check() ? true : false }}"
		cart-update-url="{{ route('web.cart.update') }}"
		branch-block-url="{{ route('guest.branch.block-dates-intervals') }}"
		coupon-discount-url="{{ route('guest.coupon-discount') }}"
		terms-condition-text="{{ $terms_condition }}"
	></booking-view>   
</div>

@endsection