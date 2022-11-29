<template>
	<div class="card overlay-hoverable position-relative product--card shadow">
		<div class="position-relative">
			<!-- <div class="img-fluid card-img-top rounded-0" :style="background-image: url('item.image_path')"></div> -->
			<img :src="item.image_path" class="img-fluid card-img-top rounded-0" alt="">
		</div>
		<div class="card-body theme--cardBg">
			<h6 class="card-title font-weight-bold theme--text mb-0">{{ item.name }}</h6>
		</div>
		
		<div class="card-footer card-footer-details border-0 theme--cardBg">
			<div class="row">
				<div class="col-md-8 col-sm-12 col-12">
					<span class="card--duration inlineBlock-parent"><img class="img-contain mr-2" src="/images/assets/clock.png" alt=""><small class="font-weight-bold text-light-brown">{{ item.duration_label }}</small></span>	
				</div>
				<div class="col-md-4 col-sm-12 col-12 text-right">
					<span><img class="img-contain mr-2" src="/images/assets/timer.png" alt=""><small class="font-weight-bold text-light-brown">{{ item.difficulty }}</small></span>
				</div>
			</div>
		</div>

		<div class="card--overlay py-4">
			<div class="card--overlay-inner w-90 mx-auto">
				<div class="row mb-3">
					<div class="col-12">
						<h6 class="card-title font-weight-bold theme--text mb-0">{{ item.name }}</h6>
					</div>
				</div>
				<div class="row mb-4 card-footer-details">
					<div class="col-md-8 col-sm-12 col-12">
						<span class="card--duration"><img class="img-contain mr-2" src="/images/assets/clock.png" alt=""><small class="font-weight-bold text-light-brown">{{ item.duration_label }}</small></span>	
					</div>
					<div class="col-md-4 col-sm-12 col-12 text-right">
						<span><img class="img-contain mr-2" src="/images/assets/timer.png" alt=""><small class="font-weight-bold text-light-brown">{{ item.difficulty }}</small></span>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<div class="w-100 overlay--desc scroll-custom">
							<span v-html="item.description"></span>	
						</div>
					</div>
				</div>

				<div class="row mt-2">
					<div class="col-12 text-center product-btn__holder">
						<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" data-toggle="modal" data-target="#exampleModal" @click="$emit('selected', item)">
							BOOK
						</button>
					</div>
				</div>
			</div>
		</div>
<!-- 
		<booking-modal></booking-modal> -->
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