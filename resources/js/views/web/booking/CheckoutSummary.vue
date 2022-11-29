<template>
	<div class="frm-cntnr mt-5">
		<div class="w-100 mb-5">
			<p class="frm-title text-secondary">CHECKOUT SUMMARY</p>
		</div>

		<div class="w-100">
			<div class="row my-4">
				<div class="col-md-2 col-sm-3 col-3">
					<small class="text-muted">Location</small>
				</div>
				<div class="col-md-10 col-sm-9 col-9">
					<small class="text-pink font-weight-bold">SM Aura, Taguig, Metro Manila</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-md-2 col-sm-3 col-3">
					<small class="text-muted">Type of Booking</small>
				</div>
				<div class="col-md-10 col-sm-9 col-9">
					<small class="text-pink font-weight-bold">Regular</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-12 mb-2">
					<small class="text-muted">Baking Schedule</small>
				</div>
				
				<div class="sched--holder inlineBlock-parent">
					<div v-for="card in cards" class="col-md-3 col-sm-12 col-12 px-4 py-4 shadow summary--card shadown mb-3 mr-3">
						<i class="far fa-times-circle close--card text-primary"></i>
						<div class="row mb-4">
							<div class="col-12">
								<small class="text-muted"><span><img class="img-contain summary-icon mr-2" src="../../../../../public/images/assets/product1.png" alt="">Earl Grey Chiffon Sandwiches</span></small>
							</div>
						</div>
						<div class="row mb-3 card--details">
							<div class="col-9">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="../../../../../public/images/assets/clock.png" alt="">2 HOURS and 30 MINS</span></small>
							</div>
							<div class="col-3">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="../../../../../public/images/assets/timer.png" alt="">3/5</span></small>
							</div>
						</div>
						<div class="row mb-4 card--details">
							<div class="col-9">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="../../../../../public/images/assets/calendar.png" alt="">February 21, 2020 at 10:30 AM</span></small>
							</div>
							<div class="col-3">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="../../../../../public/images/assets/user2.png" alt="">1</span></small>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<small class="mb-0 font-weight-bold">P 2,500.00</small>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row my-4">
				<div class="col-2">
					<small class="text-muted">Total</small>
				</div>
				<div class="col-10">
					<small class="text-pink font-weight-bold">P 5,000.00</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-2">
					<small class="text-muted">Voucher Code</small>
				</div>
				<div class="col-10">
					<small class="text-pink font-weight-bold">None</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-2">
					<small class="text-muted">Payments Method</small>
				</div>
				<div class="col-10">
					<small class="text-pink font-weight-bold">Paynamics</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<small class=""><span class="checkbox--holder"><input type="checkbox" checked="checked" class="mr-4"><span class="checkbox"></span>By ticking this box, you agree to our <a class="text-pink" href="#">Terms of Conditions</a> and that you have read our <a class="text-pink" href="#">Privacy Policy</a></span></small>
			</div>

			<div class="row my-6">
				<div class="inlineBlock-parent">
					<button class="btn btn-outlined-white shadow font-weight-bold text-primary rounded-btn px-4 mr-2">
						BACK
					</button>
					<button class="btn btn-primary font-weight-bold text-white px-4 rounded-btn" data-toggle="modal" data-target="#termsModal">
						CHECKOUT
					</button>
				</div>
			</div>			

		</div>
	</div>
</template>

<script>
	export default {

		data: function() {
			return {
				cards: [],
				cards: 2,
			}
		}	
	}
</script>