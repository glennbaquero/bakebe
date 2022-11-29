@extends('web.auth-master')

@section('meta:title', 'Login')

@section('content')
<div class="frm-cntnr bg-background hdr--margin">
	<div class="frm-bckgrnds left--bg desktop-show" style="background-image: url('images/assets/leftcake.png')"></div>
	<div class="frm-bckgrnds right--bg desktop-show" style="background-image: url('images/assets/rightcake.png')"></div>

	<div class="w-30 mx-auto hdr--margin">
		test
		<login-view
			submit-url="{{ route('web.login')}}"
		></login-view>
	</div>
</div>

@endsection