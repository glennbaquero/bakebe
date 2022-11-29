<template>
	<div class="frm-cntnr step--holder bg-orange">
		<div class="w-90 mx-auto step-holder__inner desktop-show">
			<div class="inlineBlock-parent">
				<div class="w-80 align-t">
					<div class="vertical-parent">
						<div class="vertical-align">
							<div class="inlineBlock-parent">
								<div class="w-20 step--menu  inlineBlock-parent" :class="step === 1 ? 'active' : null">
									<div class="w-20 h-100">
										<div class="step--number text-center shadow">
											<div class="vertical-parent">
												<div class="vertical-align">
													<small class="mb-0 font-weight-bold text-white">1</small>	
												</div>
											</div>
										</div>
									</div
									><div class="w-80 h-100">
										<small class="mb-0 text-white font-weight-bold">Location</small>
									</div>
								</div
								><div class="w-20 step--menu inlineBlock-parent" :class="step === 2 ? 'active' : null">
									<div class="w-20 h-100">
										<div class="step--number text-center shadow">
											<div class="vertical-parent">
												<div class="vertical-align">
													<small class="mb-0 font-weight-bold text-white">2</small>	
												</div>
											</div>
										</div>
									</div
									><div class="w-80 h-100">
										<small class="mb-0 text-white font-weight-bold">Type of Booking</small>
									</div>
								</div
								><div class="w-20 step--menu inlineBlock-parent" :class="step === 3 ? 'active' : null">
									<div class="w-20 h-100">
										<div class="step--number text-center shadow">
											<div class="vertical-parent">
												<div class="vertical-align">
													<small class="mb-0 font-weight-bold text-white">3</small>	
												</div>
											</div>
										</div>
									</div
									><div class="w-80 h-100">
										<small class="mb-0 text-white font-weight-bold">Choose your pastry</small>
									</div>
								</div
								><div class="w-20 step--menu inlineBlock-parent" :class="step === 4 ? 'active' : null">
									<div class="w-20 h-100">
										<div class="step--number text-center shadow">
											<div class="vertical-parent">
												<div class="vertical-align">
													<small class="mb-0 font-weight-bold text-white">4</small>	
												</div>
											</div>
										</div>
									</div
									><div class="w-80 h-100">
										<small class="mb-0 text-white font-weight-bold">Payment option</small>
									</div>
								</div
								><div class="w-20 step--menu inlineBlock-parent"  :class="step === 5 ? 'active' : null">
									<div class="w-20 h-100">
										<div class="step--number text-center shadow">
											<div class="vertical-parent">
												<div class="vertical-align">
													<small class="mb-0 font-weight-bold text-white">5</small>	
												</div>
											</div>
										</div>
									</div
									><div class="w-80 h-100">
										<small class="mb-0 text-white font-weight-bold">Checkout summary</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div
				><div class="w-20 align-t">
					<div class="vertical-parent">
						<div class="vertical-align">
							<div class="text-center w-100 inlineBlock-parent">
								<button class="btn btn-white font-weight-bold text-primary rounded-btn custom-btn mr-2" @click="$emit('backForm')" v-if="step >= 2">
									BACK
								</button>
								<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" @click="nextAction()" v-if="showNext">
									NEXT
								</button>
								<!-- <button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" data-toggle="modal" data-target="#loginModal">
									NEXT
								</button> -->
							</div>
						</div>
					</div> 
				</div>
			</div>
		</div>

		<!-- Mobile Responsive -->

		<div class="w-90 mx-auto m-step__holder py-4 mobile-show">
			<div class="inlineBlock-parent">
				<div class="w-60 text-left">
					<div class="inlineBlock-parent">
						<i class="fas fa-chevron-left text-white mr-2" @click="$emit('backForm')" v-if="step >= 2"></i>
						<div class="m-step__number text-center shadow mr-2">
							<div class="vertical-parent">
								<div class="vertical-align">
									<span><small class="mb-0 font-weight-bold text-white">{{ step }}</small></span>	
								</div>
							</div>
						</div>

						<small class="font-weight-bold text-white">{{ stepLabel }}</small>
					</div>
				</div
				><div class="w-40 text-right">
					<button class="btn btn-primary rounded-btn font-weight-bold" @click="nextAction()" v-if="showNext">Next</button>
				</div>
			</div>
		</div>
	</div>
</template>
<script>
	export default {
		props: {
			step: Number,
			showNext: Boolean
		},

		computed: {
			stepLabel() {
				var result = 'Location';
				switch(this.step) {
					case 1: 
						result = 'Location';
						break;
					case 2: 
						result = 'Type of booking';
						break;
					case 3: 
						result = 'Choose your pastry';
						break;
					case 4: 
						result = 'Payment option';
						break;
					case 5: 
						result = 'Checkout summary';
						break;
					
				}

				return result;
			}
		},

		methods: {
			nextAction() {
				if(this.$parent.authenticated != '1' && this.step === 4) {
					$('.login--modal').modal('toggle');
					// window.location.href = '/login';
				} else {
					this.$emit('nextForm');
				}
			},
		}
	}
</script>