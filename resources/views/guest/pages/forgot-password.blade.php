@extends('guest.master')

{{-- @section('meta:title', 'Login') --}}

@section('content')

<div class="frm-cntnr lgn--holder bg-background hdr--padding">
	<div class="frm-bckgrnds left--bg desktop-show" style="background-image: url('images/assets/leftcake.png')"></div>
	<div class="frm-bckgrnds right--bg desktop-show" style="background-image: url('images/assets/rightcake.png')"></div>
	<div class="w-30 mx-auto">
		<forgot-password
			request-url="{{ route('web.password.email') }}"
		></forgot-password>
	</div>
</div>

@endsection