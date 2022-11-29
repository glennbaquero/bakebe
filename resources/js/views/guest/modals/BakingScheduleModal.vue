<template>
	<!-- Modal -->
	<div class="modal fade baking--modal" id="bakingModal" tabindex="-1" role="dialog" aria-labelledby="bakingModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="w-90 mx-auto py-4" v-if="items.length">
	    		<div class="row mr-0 ml-0">
	            	<div class="col-12 px-0">
	            		<h6 class="font-weight-bold mb-4">Baking Schedule</h6>
	            	</div>
	            </div>

				
	            <div class="row mr-0 ml-0" v-for="(item, key) in items">
            		<div class="col-2 px-0 desktop-show">
            			<div class="product--modal-img" :style="{ backgroundImage: 'url('+item.selectedPastry.image_path+')' }"></div>
            		</div>
            		<div class="col-md-6 col-sm-12 col-12">
            			<div class="row mb-2">
							<div class="col-12">
								<small class="mb-0 font-weight-bold">{{ item.selectedPastry.name }}</small>
							</div>
						</div>
						<div class="row mb-3 card--modal-details">
							<div class="col-md-9 col-sm-8 col-8">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="/images/assets/clock.png" alt="">{{ item.selectedPastry.duration_label }}</span></small>
							</div>
							<div class="col-md-3 col-sm-4 col-4">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="/images/assets/timer.png" alt="">{{ item.selectedPastry.difficulty }}</span></small>
							</div>
						</div>
						<div class="row mb-4 card--modal-details">
							<div class="col-md-9 col-sm-8 col-8">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="/images/assets/calendar.png" alt="">{{ toDate(item.dateSelected) }} at {{ toTime(item.selectedTime, 'hh:mm A') }} </span></small>
							</div>
							<div class="col-md-3 col-sm-4 col-4">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="/images/assets/user2.png" alt="">{{ item.attendees }}</span></small>
							</div>
						</div>
            		</div>
            		<div class="col-md-4 col-sm-12 col-12 baking-buttons__holder text-right">
            			<div class="inlineBlock-parent mb-4">
            				<button class="btn btn-orange custom--btn py-0 px-2 w-auto mr-2" @click="removeItem(key, item)">
            					<span><i class="fas fa-trash-alt"></i> Remove</span>
            				</button>
            				<button class="btn btn-pink custom--btn py-0 px-2 w-auto " @click="editItem(key, item)">
            					<span><i class="fas fa-pen mr-1"></i> Edit</span>
            				</button>
            			</div>

            			<small class="font-weight-bold modal--amount">{{ toMoney(item.totalPayment) }}</small>
            		</div>
            	</div>
            	<div class="divider mb-4"></div>

            	<div class="row">
            		<div class="col-6">
            			<p class="font-weight-bold text-primary">Total</p>
            		</div>
            		<div class="col-6 text-right">
            			<p class="font-weight-bold text-primary">{{ toMoney(grandTotal) }}</p>
            		</div>
            	</div>
            	<div class="row mt-2">
            		<div class="col-12 text-center">
            			<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" @click="nextStep()">
							NEXT
						</button>
            		</div>
            	</div>	
	    	</div>
	    	<div class="w-90 mx-auto py-4" v-else>
	    		<div class="row mr-0 ml-0">
	            	<div class="col-12 px-0">
	            		<h6 class="font-weight-bold mb-4">Baking Schedule</h6>
	            	</div>
	            </div>
	    		<div class="row mr-0 ml-0">
	    			<div class="col-6">
            			<div class="row mb-2">
							<div class="col-12">
					    		NO RESERVATION FOUND
		    				</div>
		    			</div>
		    		</div>
	    		</div>
	    	</div>
            
	    </div>
	  </div>
	</div>
</template>

<script>
	import { EventBus } from 'Root/EventBus.js';
	import DateMixins from 'Mixins/date.js';
	import NumberMixins from 'Mixins/number.js';

	export default {
		
		mixins: [ DateMixins, NumberMixins ],

		data() {
			return {
				items: [],
			}
		},

		created() {
			EventBus.$on('show--cart', () => {
				this.init();
			})
		},


		computed: {
			grandTotal() {
				var total = 0;

				_.each(this.items, (item) => {
					total += parseFloat(item.totalPayment);
				})

				return total;
			}
		},

		mounted() {
		},

		methods: {
			init() {
				if(this.$parent.authenticated != '1') {
					this.items = sessionStorage.getItem('cart_items') ? JSON.parse(sessionStorage.getItem('cart_items')) : [];
				} else {
					axios.post(this.$parent.cartFetchUrl)
						.then(response => {
							this.items = response.data.items;
							this.$parent.cart = response.data.items;
						})
				}
			},

			removeItem(key, item) {
				if(this.$parent.authenticated == '1') {
					axios.post(item.removeItemUrl)
						.then(response => {
							this.init();
						});

				} else {
					this.items.splice(key, 1); 
					sessionStorage.setItem('cart_items', JSON.stringify(this.items));

					this.$parent.cart = JSON.parse(sessionStorage.getItem('cart_items'));
					this.$parent.$children[8].item_count = this.$parent.cart.length
					this.init();
				}
			},

			editItem(key, item) {
				EventBus.$emit('booking--data', item, key);
				setTimeout(() => {
					$('.baking--modal').modal('toggle');
					$('.edit--booking--modal').modal('toggle');
				}, 200)
			},

			nextStep() {
				$('.baking--modal').modal('toggle');
				this.$nextTick(() => {
					this.$parent.step += 1;
				})
			}
		}

	}

</script>