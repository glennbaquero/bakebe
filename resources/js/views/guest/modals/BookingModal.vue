<template>
	<div>
	<!-- Modal -->
	<div class="modal fade booking--modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
            <div class="row">
            	<div class="col-md-5 col-sm-12 col-12 bg-primary pr-0">
            		<div class="w-85 mx-auto text-right mobile-show">
            			<i class="far fa-times-circle close--booking text-white py-3 mr-0" data-dismiss="modal"></i>	
            		</div>
            		
            		<div class="modal--img" :style="{ backgroundImage: 'url('+selectedPastry.image_path+')' }"></div>
					<!-- <img class="img-contain modal--img" src="images/assets/product1.png" alt=""> -->

					<div class="w-85 mx-auto mt-3 time--holder">
						<h5 class="font-weight-bold text-white">{{ toMoney(pastryPrice) }}</h5>
						<p class="text-white">{{ selectedPastry.name }}</p>
						<div class="row mb-2">
							<div class="col-8">
								<span><img class="modal--icon img-contain mr-2" src="/images/assets/clock.png" alt=""><small class="font-weight-bold text-white">{{ selectedPastry.duration_label }}</small></span>	
							</div>
							<div class="col-4 text-right">
								<span><img class="modal--icon img-contain mr-2" src="/images/assets/timer.png" alt=""><small class="font-weight-bold text-white">{{ selectedPastry.difficulty }}</small></span>
							</div>
						</div>

						<span class="mb-0 text-white modal--desc scroll-custom" v-html="selectedPastry.description"></span>
						
					</div>            		
            	</div>
            	<div class="col-md-7 col-sm-12 col-sm-12 px-0 shadow align-self-center">
            		<div class="w-85 mx-auto py-5">
            			<div class="booking-modal__content scroll-custom">
	            			<h6 class="font-weight-bold mb-4">How many are attending?</h6>
							<div class="row mb-3">
								<div class="col-4 pr-0 align-self-center">
									<small class="mb-0">Number of persons</small>	
								</div>
								<div class="col-2 px-0 align-self-center">
									<div class="form-group mb-0">
										<div class="input-group">
											<input type="number" class="form-control modal--num-field" v-model="bookingData.attendees" :min="minimunAttendee" max="2">
										</div>
									</div>
								<!-- 	<number-field
									class="modal--num-field"
									v-model="bookingData.attendees"
									:max-input="2"
									:min-input="1"
									></number-field>	 -->
								</div>
								<div class="col-6 align-self-center">
									<small class="max--number text-light-brown">Max. of 2 persons</small>
								</div>
							</div>

							<div class="row mb-3" v-if="bookingData.attendees > 1">
								<div class="col-4">
									<small class="mb-0">Bake the pastry</small>
								</div>
								<div class="col-8">
									<div class="row">
										<span><small><input type="radio" name="is_one_pastry_per_person" class="mr-3" v-model="payloads.is_one_pastry_per_person" :value="true"> One Pastry per person</small></span>	
									</div>
									<div class="row">
										<span><small><input type="radio" name="is_one_pastry_per_person" class="mr-3" v-model="payloads.is_one_pastry_per_person" :value="false"> Baking the recipe with a peer</small></span>	
									</div>
									<small class="max--number text-light-brown">+ Additional charge will be put on your total bill</small>
								</div>
							</div>
							<h6 class="font-weight-bold">Choose your appointment schedule</h6>
							
							<div class="row">
								<div class="col-md-8 col-sm-12 col-12">
									<!-- <datepicker @change="dateChanged()" v-model="payloads.dateSelected"></datepicker> -->
									<div class="form-group">
										<input type="text" class="form-control flatpickr-input" readonly v-model="bookingData.dateSelected" @change="dateChanged()">
									</div>
								</div>
								<div class="col-md-4 col-sm-12 col-12">
									<div class="vertical-parent">
										<div class="vertical-align">
											<div class="inlineBlock-parent">
												<div class="modal--dot bg-primary"></div>
												<small class="max--number font-weight-bold">CHOSEN DATE</small>
											</div>

											<div class="inlineBlock-parent">
												<div class="modal--dot bg-light-gray"></div>
												<small class="max--number font-weight-bold">FULLY BOOKED</small>
											</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row booking--time">
								<div class="col-4 pr-0 align-self-center">
									<small class="mb-0">Available time:</small>
								</div>
								<div class="col-3 px-0 align-self-center">
									<select-field 
									class="modal--time"
									v-model="bookingData.selectedTime"
									:items="timeslots"
									item-value="value"
									item-text="label"
									></select-field>
								</div>
								<div class="col-5 align-self-center">
									<small class="max--number text-light-brown desktop-show">Please select date first</small>
								</div>
							</div>
							<div class="row mt-1">
								<div class="col-12">
									<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" v-if="showButton" @click="addToCart()">
										BOOK
									</button>
								</div>
							</div>
            			</div>
            		</div>
            	</div>
            </div>
	    </div>
	  </div>
	</div>

	<loading 
		:active.sync="isLoading" 
        :is-full-page="true"
        color="#e8627c"
	></loading>
	</div>
</template>

<script>
import NumberField from 'Components/inputs/NumberField.vue';
import Datepicker from 'Components/datepickers/Datepicker.vue';
import SelectField from 'Components/inputs/Select.vue';
import AppointmentModal from '../modals/AppointmentModal.vue';
import NumberMixins from 'Mixins/number.js';
import { EventBus } from 'Root/EventBus.js';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import ArrayMixin from 'Mixins/array.js';

	export default {
		props: {
			selectedPastry: Object,
			blockDatesIntervals: Array,
			timeslotUrl: String,
			fullybookedUrl: String,
			createItemUrl: String,
			payloads: Object
		},

		components: {
			'number-field' : NumberField,
			'datepicker' : Datepicker,
			'select-field' : SelectField,
			'appointment-modal' : AppointmentModal,
			Loading
		}, 

		mixins: [ NumberMixins, ArrayMixin ],

		data() {
			return {
				timeslots: [],
				fullybookDates: [],
				bookingData: {
					attendees: 1,
					totalPayment: 0.00
				},
				isLoading: false,
				minimunAttendee: 1,
				disabledDates: ['2020-03-13']
			}
		},

		computed: {
			showButton() {
				var result = false;
				if(this.bookingData.dateSelected && this.bookingData.selectedTime) {
					result = true;
				} else if(this.bookingData.dateSelected && this.bookingData.selectedTime && this.$parent.$parent.payloads.promoSelected.promo_category_id === 3 && this.$parent.$parent.cart.length <= 1) {
					result = true;
				}

				return result;
			},

			pastryPrice() {
				var rate = parseFloat(this.selectedPastry.regular_amount);
				var additional_fee = parseFloat(this.selectedPastry.additional_regular_amount)

				if(this.payloads.selectedType.id === 2) {
					rate = parseFloat(this.selectedPastry.express_amount);
					additional_fee = parseFloat(this.selectedPastry.additional_express_amount)
				}

				var result = rate;
				this.payloads.with_two_attendees = false;
				if(this.bookingData.attendees > 1) {
					if(this.payloads.is_one_pastry_per_person) {
						result = rate * 2;
					} else {
						result = rate + additional_fee;
					}

					if(this.$parent.$parent.payloads.promoSelected.promo_category_id === 3) {
						result -= rate;
					}
					
					this.payloads.with_two_attendees = true;
				} 

				return result;
			}
		},

		watch: {
			fullybookDates(val) {
				var dates = {};
				_.each(val, (book) => {
					if(!book.is_available) {
						dates[parseInt(book.fullybooked_date)] = 0;
					}
				})

				var classDict = {
				    0: 'flatpickr-disabled fully__booked',
				};

				var $this = this;

				function disableDays(date) {
					var disable = false;

					if($this.payloads.promoSelected.promo_category_id === 1) {
						disable = (date.getDay() === 0 || date.getDay() === 6);
					} 

					if($this.payloads.promoSelected.promo_category_id === 2) {
						disable = (date.getDay() === 1 || date.getDay() === 2 || date.getDay() === 3 || date.getDay() === 4 || date.getDay() === 5);
					}
				    // return true to disable
				    return disable;
				}

				function blockDates(date) {
					var dates = [];
					_.each($this.$parent.$parent.blocklists, (block) => {
						if(block.is_whole_day) {
							dates.push(block.date);
						}
					})
					return dates.includes(date.toISOString().substring(0, 10));
				}

				var minimumDate = moment().add(3, 'days').format('Y-MM-DD');

				if(this.payloads.selectedType.id === 1) {
					minimumDate = 'today';
				}

				flatpickr(".flatpickr-input", {
				    onDayCreate: function(dObj, dStr, fp, dayElem) {
				      	var date = dayElem.dateObj,
				        // Note the + 1 in the month.
				        key = date.getFullYear() + $this.get2DigitFmt(date.getMonth() + 1) + $this.get2DigitFmt(date.getDate()),
				        value = classDict[dates[key]];
				      	if (value) {
				        	dayElem.className += ' ' + value;
				      	}
				    }, inline: true, minDate: minimumDate,
				 	disable: [ disableDays, blockDates ],
				});
			},

			selectedPastry(val) {
				if(!_.isEmpty(val)) {
					this.dateChanged()
				}
			}
		},

		mounted() {
			this.init();
			this.setupAttendeesForBirthdayPromo();
		},

		methods: {
			init() {
				this.isLoading = true;
				var data = {
					branch_id: this.payloads.branchSelected.id,
					duration: this.selectedPastry.duration
				}

				axios.post(this.fullybookedUrl, data)
					.then(response => {
						this.fullybookDates = response.data.lists;
						this.isLoading = false;
					})
			},

			setupAttendeesForBirthdayPromo() {
				if(this.$parent.$parent.payloads.promoSelected.promo_category_id === 3) {
					this.bookingData.attendees = 2;
					this.minimunAttendee = 2;
				}
			},

			get2DigitFmt(val) {
			  	return ('0' + val).slice(-2);
			},

			dateChanged() {
				this.isLoading = true;
				this.timeslots = [];
				setTimeout(() => {
					var data = {
						branch_id: this.payloads.branchSelected.id,
						date: this.bookingData.dateSelected,
						duration: this.selectedPastry.duration,
					}
					axios.post(this.timeslotUrl, data)
						.then(response => {
							var lists = response.data.list;
							_.each(lists, (list) => {
								if(list.show) {
									this.timeslots.push(list);
								}
							})

							this.isLoading = false;
						})

						// this.init();
					}, 50)
			},

			bookingTotal() {
				var total = parseFloat(this.payloads.selectedType.rate);
				if(this.bookingData.attendees > 1) {
					total += parseFloat(this.payloads.selectedType.additional_fee); 
				}

				this.bookingData.totalPayment = total;
			},

			addToCart() {
				this.bookingTotal();

				this.payloads.selectedPastry = this.selectedPastry;
				this.payloads.pastryId = this.selectedPastry.id;
				this.payloads.selectedTime = this.bookingData.selectedTime;
				this.payloads.dateSelected = this.bookingData.dateSelected;
				this.payloads.attendees = parseInt(this.bookingData.attendees);
				this.payloads.totalPayment = parseFloat(this.pastryPrice);
				this.payloads.grandTotal = parseFloat(this.pastryPrice);

				if(this.$parent.$parent.authenticated != '1') {
					var sessionStored = JSON.parse(sessionStorage.getItem('cart_items'));
					var array = [];

					if(sessionStored) {
						array = sessionStored;
						array.push(this.payloads);
					} else {
						array.push(this.payloads);
					}

					sessionStorage.setItem('cart_items', JSON.stringify(array));
					this.$parent.$parent.cart = array;
					this.$parent.item_count = this.$parent.$parent.cart.length;
					this.bookingData = {
						attendees: 1,
						totalPayment: 0.00
					}

				} else {
					var data = {
						item: this.payloads
					};

					axios.post(this.createItemUrl, data)
						.then(response => {
							this.$parent.$parent.cart = response.data.cart;
							this.$parent.$parent.payloads.grandTotal = response.data.cartTotal;
							this.bookingData = {
								attendees: 1,
								totalPayment: 0.00
							}
						})
				}
				
				$('.appointment--modal').modal('toggle');
			},

			showSession() {
				var cart_items = JSON.parse(sessionStorage.getItem('cart_items'));
				console.log(cart_items);
			}
		}
	}

</script>