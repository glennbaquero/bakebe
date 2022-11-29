<template>
	<div>
	<!-- Modal -->
	<div class="modal fade edit--booking--modal" id="editBookingModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
            <div class="row">
            	<div class="col-5 bg-primary pr-0">
            		<div class="modal--img" :style="{ backgroundImage: 'url('+selectedPastry.image_path+')' }"></div>
					<!-- <img class="img-contain modal--img" src="images/assets/product1.png" alt=""> -->

					<div class="w-85 mx-auto mt-3 time--holder pb-5">
						<h5 class="font-weight-bold text-white">{{ toMoney(pastryPrice) }}</h5>
						<p class="text-white">{{ selectedPastry.name }}</p>
						<div class="row mb-3">
							<div class="col-8">
								<span><img class="modal--icon img-contain mr-2" src="/images/assets/clock.png" alt=""><small class="font-weight-bold text-white">{{ selectedPastry.duration_label }}</small></span>	
							</div>
							<div class="col-4 text-right">
								<span><img class="modal--icon img-contain mr-2" src="/images/assets/timer.png" alt=""><small class="font-weight-bold text-white">{{ selectedPastry.difficulty }}</small></span>
							</div>
						</div>

						<span class="mb-0 text-white modal--desc" v-html="selectedPastry.description"></span>
						
					</div>            		
            	</div>
            	<div class="col-7 px-0 shadow">
            		<div class="w-85 mx-auto py-5">
            			<h6 class="font-weight-bold mb-4">How many are attending?</h6>
						<div class="row mb-3">
							<div class="col-4 pr-0">
								<small class="mb-0">Number of persons</small>	
							</div>
							<div class="col-2 px-0">
								<div class="form-group">
									<div class="input-group">
										<input type="number" class="form-control modal--num-field" v-model="editBookingData.attendees" :min="minimunAttendee" max="2">
									</div>
								</div>
							<!-- 	<number-field
								class="modal--num-field"
								v-model="editBookingData.attendees"
								:max-input="2"
								:min-input="1"
								></number-field>	 -->
							</div>
							<div class="col-6">
								<small class="max--number text-light-brown">Max. of 2 persons</small>
							</div>
						</div>
						<div class="row mb-3" v-if="editBookingData.attendees > 1">
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
							<div class="col-8">
								<!-- <datepicker @change="dateChanged()" v-model="payloads.dateSelected"></datepicker> -->
								<div class="form-group">
									<input type="text" class="form-control flatpickr-input-edit" readonly v-model="editBookingData.dateSelected" @change="dateChanged()">
								</div>
							</div>
							<div class="col-4">
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
						
						<div class="row">
							<div class="col-3 pr-0">
								<small class="mb-0">Available time:</small>
							</div>
							<div class="col-3 px-0">
								<select-field 
								class="modal--time"
								v-model="editBookingData.selectedTime"
								:items="timeslots"
								item-value="value"
								item-text="label"
								></select-field>
							</div>
							<div class="col-6"></div>
						</div>
						<div class="row mt-1">
							<div class="col-12">
								<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" @click="updateItem()">
									UPDATE
								</button>
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

	export default {
		props: {
			blockDatesIntervals: Array,
			timeslotUrl: String,
			fullybookedUrl: String,
			payloads: Object,
			bookingData: {
				default() {
					return {
						attendees: 1
					}
				},

				type: Object
			},
		},

		components: {
			'number-field' : NumberField,
			'datepicker' : Datepicker,
			'select-field' : SelectField,
			'appointment-modal' : AppointmentModal,
			Loading
		}, 

		mixins: [ NumberMixins ],

		data() {
			return {
				timeslots: [],
				fullybookDates: [],
				selectedPastry: {},
				keySelected: null,
				selectedCartItem: {},
				is_increment: false,
				isLoading: false,
				editBookingData: this.bookingData,
				minimunAttendee: 1
			}
		},

		computed: {
			pastryPrice() {
				var rate = parseFloat(this.selectedPastry.regular_amount);
				var additional_fee = parseFloat(this.selectedPastry.additional_regular_amount);

				if(this.payloads.selectedType.id === 2) {
					rate = parseFloat(this.selectedPastry.express_amount);
					additional_fee = parseFloat(this.selectedPastry.additional_express_amount);
				}
				
				var result = rate;
				this.payloads.with_two_attendees = false;
				if(this.editBookingData.attendees > 1) {
					if(this.payloads.is_one_pastry_per_person) {
						result = rate * 2;
					} else {
						result = rate + additional_fee;
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
					console.log(dates);
					return dates.includes(date.toISOString().substring(0, 10));
				}

				var $this = this;

				var minimumDate = moment().add(3, 'days').format('Y-MM-DD');

				if(this.payloads.selectedType.id === 1) {
					minimumDate = 'today';
				}

				flatpickr(".flatpickr-input-edit", {
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

			'editBookingData.attendees': function(newValue, oldValue) {
				if(newValue > oldValue) {
					this.is_increment = true;
				} else {
					this.is_increment = false;
				}
			}
		},

		created() {
			EventBus.$on('booking--data', (item, key) => {
				this.editBookingData.selectedTime = item.selectedTime;
				this.editBookingData.dateSelected = item.dateSelected;
				this.editBookingData.attendees = item.attendees;
				this.selectedPastry = item.selectedPastry;
				this.keySelected = key;
				this.selectedCartItem = item;
				this.init();
				this.dateChanged();
				this.setupAttendeesForBirthdayPromo();
			});
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

			runFlatPickr() {
				var dates = {};

				_.each(this.fullybookDates, (book) => {
					dates[book.date] = 0;
				})

				var classDict = {
				    0: 'fully__booked',
				};

				var $this = this;

				 flatpickr(".flatpickr-input-edit", {
				    onDayCreate: function(dObj, dStr, fp, dayElem) {
				      	var date = dayElem.dateObj,
				        // Note the + 1 in the month.
				        key = date.getFullYear() + $this.get2DigitFmt(date.getMonth() + 1) + $this.get2DigitFmt(date.getDate()),
				        value = classDict[dates[key]];
				      	if (value) {
				        	dayElem.className += ' ' + value;
				      	}
				    }, inline: true, minDate: "today"
				});
			},

			setupAttendeesForBirthdayPromo() {
				if(this.payloads.promoSelected.promo_category_id === 3) {
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
						date: this.editBookingData.dateSelected,
						duration: this.selectedPastry.duration
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

					}, 50)
			},

			bookingTotal() {
				var total = parseFloat(this.payloads.selectedType.rate);
				if(this.editBookingData.attendees > 1) {
					total += parseFloat(this.payloads.selectedType.additional_fee); 
				}

				this.editBookingData.totalPayment = total;
			},

			updateItem() {
				this.bookingTotal();

				if(this.$parent.$parent.authenticated != '1') {
					var sessionStored = JSON.parse(sessionStorage.getItem('cart_items'));

					var array = [];

					sessionStored[this.keySelected].selectedTime = this.editBookingData.selectedTime;
					sessionStored[this.keySelected].dateSelected = this.editBookingData.dateSelected;
					sessionStored[this.keySelected].attendees = parseInt(this.editBookingData.attendees);
					sessionStored[this.keySelected].totalPayment = parseFloat(this.editBookingData.totalPayment);

					array = sessionStored;
					

					sessionStorage.setItem('cart_items', JSON.stringify(array));
					this.$parent.$parent.cart = array;
				} else {
					var data = {
						attendees: parseInt(this.editBookingData.attendees),
						scheduled_date: this.editBookingData.dateSelected,
						start_time: this.editBookingData.selectedTime,
						grand_total: parseFloat(this.pastryPrice),
						is_increment: this.is_increment
					};
					axios.post(this.selectedCartItem.updateItemUrl, data)
						.then(response => {

						})
				}
				

				$('.appointment--modal').modal('toggle');
				this.editBookingData = {
					attendees: 1
				};
				this.keySelected = null;
			},

			showSession() {
				var cart_items = JSON.parse(sessionStorage.getItem('cart_items'));
				console.log(cart_items);
			}
		}
	}

</script>