<template>
	<div class="card overlay-hoverable position-relative product--card shadow">
		<div class="position-relative">
			<img src="../../../../../public/images/assets/product1.png" class="img-fluid card-img-top rounded-0" alt="">
		</div>
		<div class="card-body theme--cardBg">
			<h6 class="card-title font-weight-bold theme--text mb-0">Product Name</h6>
		</div>
		
		<div class="card-footer border-0 theme--cardBg">
			<div class="row">
				<div class="col-md-8 col-sm-12 col-12">
					<span><img class="img-contain mr-2" src="images/assets/clock.png" alt=""><small class="font-weight-bold text-light-brown">2 HOURS 30 MINS</small></span>	
				</div>
				<div class="col-md-4 col-sm-12 col-12 text-right">
					<span><img class="img-contain mr-2" src="images/assets/timer.png" alt=""><small class="font-weight-bold text-light-brown">3/5</small></span>
				</div>
			</div>
		</div>

		<div class="card--overlay py-4">
			<div class="card--overlay-inner w-90 mx-auto">
				<div class="row mb-3">
					<div class="col-12">
						<h6 class="card-title font-weight-bold theme--text mb-0">Earl Grey Chiffon Sandwiches</h6>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-8">
						<span><img class="img-contain mr-2" src="images/assets/clock.png" alt=""><small class="font-weight-bold text-light-brown">2 HOURS 30 MINS</small></span>	
					</div>
					<div class="col-4 text-right">
						<span><img class="img-contain mr-2" src="images/assets/timer.png" alt=""><small class="font-weight-bold text-light-brown">3/5</small></span>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<div class="w-100 overlay--desc">
							<p>Yum the organic Earl Grey tea Chiffon Cake with Caramel sauce and hazelnuts</p>	
						</div>
					</div>
				</div>

				<div class="row mt-2">
					<div class="col-12 text-center">
						<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" data-toggle="modal" data-target="#exampleModal">
							BOOK
						</button>
					</div>
				</div>
			</div>
		</div>

		<booking-modal></booking-modal>
	</div>
</template>

<script>
import BookingModal from '../modals/BookingModal.vue'

export default {
	methods: {
		submit() {

		}
	},

	props: {
		item: {},
	},

	components: {
		'booking-modal' : BookingModal,
	}

}
</script>