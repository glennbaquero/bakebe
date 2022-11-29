@extends('guest.master')

{{-- @section('meta:title', 'Login') --}}

@section('content')

<div class="frm-cntnr bg-background py-5">
	<div class="w-90 mx-auto">
		<dashboard-view fetch-url="{{ route('web.user.fetch-profile') }}"
		
		></dashboard-view>	
	</div>
	   
</div>

@endsection