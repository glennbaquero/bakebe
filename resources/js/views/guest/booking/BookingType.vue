<template>
	<div class="frm-cntnr mt-5">
		<div class="w-100">
			<div class="w-100 mb-5">
				<p class="frm-title text-secondary mb-3">TYPE OF BOOKING</p>

				<p>What type of booking do you prefer?</p>
			</div>

			<div class="w-100 card-type__holder inlineBlock-parent">
				<template  v-for="(type, key) in types">
				<div class="card-type shadow py-5" @click="selectedType(type)" :class="type.id === payloads.typeId ? 'selected__type' : null">
					<div class="w-80 mx-auto inlineBlock-parent">
						<div class="w-40 align-t">
							<img class="card-img img-contain" :src="type.img_src" alt="">	
						</div
						><div class="w-60 align-t">
							<h5 class="text-primary font-weight-bold mb-2">{{ type.name }}</h5>
							<p class="text-primary card-desc scroll-custom" v-html="type.description"></p>
							<div class="w-100">
								<div class="row">
									<div class="col-2">
										<img class="card-icon img-contain mr-2" src="/images/assets/clock.png" alt="">		
									</div>
									<div class="col-10">
										<small class="text-light-brown bold font-weight-bold">{{ type.expected_duration }}</small>	
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div
				><p class="mb-0 w-10 font-weight-bold text-primary text-center" v-if="(key+1) < types.length">or</p
				></template><!-- <div class="card-type shadow py-5">
					<div class="w-80 mx-auto inlineBlock-parent">
						<div class="w-30 align-t">
							<img class="card-img img-contain" src="/images/assets/booking2.png" alt="">	
						</div
						><div class="w-70 align-t">
							<h5 class="text-primary font-weight-bold mb-2">REGULAR</h5>
							<p class="text-primary card-desc">Enjoy the baking experience from scratch</p>
							<small class="text-light-brown bold font-weight-bold"><span><img class="card-icon img-contain mr-2" src="/images/assets/clock.png" alt="">-1 HOUR 30 MINS - 3 HOURS</span></small>
						</div>
					</div>
				</div> -->
			</div>
		</div>
	</div>
</template>
<script>
	export default{
		props: {
			payloads: Object,
			types: Array
		},

		methods: {
			selectedType(type) {
				this.payloads.selectedType = type;
				this.payloads.typeId = type.id;
			}
		}
	}
</script>