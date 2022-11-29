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
									<li class="mb-2"><small><a class="active" href="dashboard">Booking History</a></small></li>
									<li class="mb-2"><small><a href="edit-profile">Edit Profile</a></small></li>
									<li class="mb-2"><small><a href="change-password">Change Password</a></small></li>
								</ul>
								<div class="menu--space w-100"></div>
								
								<p class="font-weight-bold mb-0 pb-4"><a class="text-muted" href="logout">Logout</a></p>
							</div>
						</div>

						{{-- Mobile Responsive --}}
						<mobile-menu>
						</mobile-menu>

					</div>
				</div
				><div class="w-70 align-t">
					<div class="w-95 mx-auto dash--content bg-white py-4 shadow">
						<div class="frm-cntnr">
							<div class="w-90 mx-auto py-3">
								<div class="w-100 mb-5 inlineBlock-parent">
									<div class="w-50">
										<p class="text-muted selected--back"><span><i class="fas fa-chevron-left text-muted"></i> Back</span></p>	
									</div
									><div class="w-50 text-right">
										<button class="btn btn-light-brown px-3 py-0 rounded-btn text-white">Print</button>
									</div>
								</div>

								<h5 class="text-primary font-weight-bold mb-2"># 123445566</h5>
								<div class="w-100 inlineBlock-parent">
									<div class="w-50">

										<div class="w-100 inlineBlock-parent">
											<p class="mr-2 text-muted">Type of Booking:</p> <p class="text-muted">Express</p>
										</div>

										<div class="w-100 inlineBlock-parent">
											<p class="mr-2 text-muted">Booking Date:</p> <p class="text-muted">February 1, 2020</p>
										</div>

										<div class="w-100 inlineBlock-parent">
											<p class="mr-2 text-muted">Location:</p> <p class="text-muted">SM Aura</p>
										</div>
									</div
									><div class="w-50">
										<div class="w-100 inlineBlock-parent">
											<p class="mr-2 text-muted">Payment Option:</p> <p class="text-muted">Paynamics</p>
										</div>

										<div class="w-100 inlineBlock-parent">
											<p class="mr-2 text-muted">Voucher Code:</p> <p class="text-muted">123455</p>
										</div>

										<div class="w-100 inlineBlock-parent">
											<p class="mr-2 text-muted">Amount:</p> <p class="text-muted">P 5000.00</p>
										</div>
									</div>
								</div>


								<div class="w-100 mt-4 desktop-show">
									<p class="text-muted">Pastries Booked:</p>
									<table class="table selected--table">
									  <thead>
									    <tr class="text-center">
									    	<th scope="col">Pastry</th>
									      	<th scope="col">Duration</th>
									      	<th scope="col">Difficulty</th>
									      	<th scope="col">Guest</th>
									      	<th scope="col">Date</th>
									      	<th scope="col">Time</th>
									    </tr>
									  </thead>
									  <tbody>
									    <tr class="text-center" v-for="invoiceItem in item.invoiceItems">
									      <td><span><img class="img-contain mr-2 sel-book__img" :src="invoiceItem.pastry_image" alt=""> <small class="text-muted">Name</small></span></td>
									      <td><small class="text-muted">Duration</small></td>
									      <td><small class="text-muted">Difficulty/5</small></td>
									      <td><small class="text-muted">3</small></td>
									      <td><small class="text-muted">February 1, 2020</small></td>
									      <td><small class="text-muted">10:00AM</small></td>
									    </tr>
									  </tbody>
									</table>
								</div>

								<!-- Mobile Responsive -->

								<div class="w-100 mt-5 mobile-show">
									<div class="w-100 inlineBlock-parent">
										<p>Pastries Booked:</p> 
									</div>

									<div class="w-100 mb-4">
										<p class="font-weight-bold mb-2">Pastry</p>

										<div class="divider w-100"></div>
									</div>

									<div class="w-100" v-for="(item, key) in items">
										<div class="inlineBlock-parent mb-3">
											<i class="fas fa-plus-circle mr-2 button--show text-orange" data-toggle="collapse" data-target="#demo"></i> <span><img class="img-contain mr-2 sel-book__img" src="/images/assets/product1.png" alt=""> <small class="text-muted">Earl Grey Chiffon Sandwiches</small></span>
										</div>

										<div id="demo" class="collapse w-100">
											<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
												<div class="w-50">
													<p class="font-weight-bold mb-0">Duration</p>
												</div
												><div class="w-50">
													<p class="mb-0 text-muted">2 Hours 30 Mins</p>
												</div>
											</div>
											<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
												<div class="w-50">
													<p class="font-weight-bold mb-0">Difficulty</p>
												</div
												><div class="w-50">
													<p class="mb-0 text-muted">3/5</p>
												</div>
											</div>
											<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
												<div class="w-50">
													<p class="font-weight-bold mb-0">Guest</p>
												</div
												><div class="w-50">
													<p class="mb-0 text-muted">N/A</p>
												</div>
											</div>
											<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
												<div class="w-50">
													<p class="font-weight-bold mb-0">Date</p>
												</div
												><div class="w-50">
													<p class="text-muted">Feb-21-2020</p>
												</div>
											</div>
											<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
												<div class="w-50">
													<p class="font-weight-bold mb-0">Time</p>
												</div
												><div class="w-50">
													<p class="text-muted">10:30 AM</p>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	   
</div>

@endsection