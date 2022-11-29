@extends('guest.master')

{{-- @section('meta:title', 'Login') --}}

@section('content')

<div class="frm-cntnr bg-background py-5">
	<div class="w-90 mx-auto">
		<div class="dashboard--holder frm-cntnr">
			<div class="w-100 inlineBlock-parent">
				<div class="w-30 align-t">
					<div class="w-90 dash--menuHolder bg-white py-4 shadow">
						<div class="frm-cntnr bg-white desktop-show">
							<div class="w-80 mx-auto mb-5">
								<div class="inlineBlock-parent">
									<img class="profile--img mr-2" src="{{ auth()->user()->renderImagePath() }}" alt="">
									<!-- <div class="profile--img" style="background-image: url('images/assets/calendar.png')"></div> -->
									<p class="font-weight-bold mb-0">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</p>
								</div>
							</div>

							<div class="w-80 mx-auto dash--menu">
								<ul class="pl-0">
									<li class="mb-2"><small><a href="dashboard">Booking History</a></small></li>
									<li class="mb-2"><small><a class="active" href="edit-profile">Edit Profile</a></small></li>
									<li class="mb-2"><small><a href="change-password">Change Password</a></small></li>
								</ul>
								<div class="menu--space w-100"></div>
								
								<p class="font-weight-bold mb-0 pb-4"><a class="text-muted" href="logout">Logout</a></p>
							</div>
						</div>
						{{-- Mobile Responsive --}}
						<mobile-menu></mobile-menu>
					</div>
				</div
				><div class="w-70 align-t">
					<div class="w-95 mx-auto dash--content bg-white py-4 shadow">
						<edit-profile
                        submit-url="{{ route('web.user.update-profile') }}"
                        fetch-url="{{ route('web.user.fetch-profile') }}"
						></edit-profile>
					</div>
				</div>
			</div>
		</div>
	</div>	   
</div>

@endsection