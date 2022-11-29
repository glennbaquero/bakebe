<template>
	<div class="frm-cntnr booking--holder">
		<step-progress :step="step" :show-next="showNext" @nextForm="nextForm()" @backForm="backForm()"></step-progress>
		<div class="w-90 mx-auto pb-5">	
			<div class="w-100 booking-holder__inner inlineBlock-parent">
				<div class="w-75 align-t">
					<location v-if="step === 1" :branches="branches" :payloads="payloads"></location>	
					<booking-type v-if="step === 2" :types="types" :payloads="payloads"></booking-type>
					
					<choose-pastry v-if="step === 3" 
						:fetch-url="fetchUrl" 
						:block-dates-intervals="blocks" 
						:timeslot-url="timeslotUrl" 
						:payloads="payloads"
						:fullybooked-url="fullybookedUrl"
						:create-item-url="createItemUrl"
					></choose-pastry>
					
					<payment-option v-if="step === 4"
						:payloads="payloads"
					></payment-option>
				</div
				><div class="w-25 align-t">
					<booking-information v-if="step != 1" :payloads="payloads" :step="step"></booking-information>	
				</div>
			</div>
			<div class="w-100">
				<checkout-summary 
					v-if="step === 5"
				></checkout-summary>	
			</div>
			<div class="w-100">
				<appointment-modal @next="nextForm()"></appointment-modal>
				<baking-modal ref="bakingModal"></baking-modal>
				<voucher-modal :voucher-checker-url="voucherCheckerUrl"></voucher-modal>
				<login-modal></login-modal>
				<privacy-policy-modal></privacy-policy-modal>
				<success-modal></success-modal>
				<birthday-modal></birthday-modal>
			</div>
		</div>
	</div>
</template>
<script>
import StepProgress from './StepProgress.vue';
import Location from './Location.vue';
import BookingType from './BookingType.vue';
import ChoosePastry from './ChoosePastry.vue';
import PaymentOption from './PaymentOption.vue';
import CheckoutSummary from './CheckoutSummary.vue';
import BookingInformation from './BookingInformation.vue';
import AppointmentModal from '../modals/AppointmentModal.vue';
import BakingScheduleModal from '../modals/BakingScheduleModal.vue';
import VoucherModal from '../modals/VoucherModal.vue';
import LoginModal from '../modals/LoginModal.vue';
import PrivacyPolicyModal from '../modals/PrivacyPolicyModal.vue';
import SuccessModal from '../modals/SuccessModal.vue';
import BirthdayModal from '../modals/BirthdayModal.vue';

export default {
	props: {
		branches: Array,
		types: Array,
		blocks: Array,
		fetchUrl: String,
		guestUserCartUrl: String,
		fetchUrlInvoices: String,
		timeslotUrl: String,
		fullybookedUrl: String,
		cartFetchUrl: String,
		createItemUrl: String,
		voucherCheckerUrl: String,
		paymayaUrl: String,
		paynamicsUrl: String,
		authenticated: String,
		paypalUrl: String,
		cartUpdateUrl: String,
		cartItemTruncateUrl: String,
		branchBlockUrl: String,
		couponDiscountUrl: String,
		termsConditionText: String,
	},

	data() {
		return {
			step: 1,
			payloads: {
				typeId: 0,
				branchId: 0,
				selectedPayment: 0,
				selectedType: {},
				dateSelected: null,
				selectedTime: null,
				with_two_attendees: false,
				is_one_pastry_per_person: false,
			},
			blocklists: [],
			cart: [],
			voucher: {},
		}
	},

	components: {
		'step-progress' : StepProgress,
		'location' : Location,
		'booking-type' : BookingType,
		'choose-pastry' : ChoosePastry,
		'payment-option' : PaymentOption,
		'checkout-summary' : CheckoutSummary,
		'booking-information' : BookingInformation,
		'appointment-modal' : AppointmentModal,
		'baking-modal' : BakingScheduleModal,
		'voucher-modal' : VoucherModal,
		'login-modal' : LoginModal,
		'privacy-policy-modal' : PrivacyPolicyModal,
		'success-modal' : SuccessModal,
		'birthday-modal' : BirthdayModal,
	}, 

	watch: {
		'payloads.promoSelected'(val) {
			console.log(val);

			// this.fetchUrl = '?type='+type; 
		}
	},

	computed: {
		showNext() {
			if(this.step === 1) {
				if(this.payloads.branchId != 0) {
					return true;
				}
			}

			if(this.step === 2) {
				if(this.payloads.typeId != 0) {
					return true;
				}
			}

			if(this.step === 3) {
				if(!_.isEmpty(this.cart)) {
					return true;
				}
			}

			if(this.step === 4) {
				sessionStorage.setItem('step', 4);
				return true;
			}

			return false;
		},

		computedCart() {
			var cart_items = [];
			var parseData = JSON.parse(sessionStorage.getItem('cart_items'));
			if(!_.isEmpty(parseData)) {
				cart_items = parseData;
				this.cart = parseData;
				this.step = 3;
				this.payloads.selectedType = parseData[0].selectedType;
				this.payloads.branchSelected = parseData[0].branchSelected;
				this.payloads.branchId = parseData[0].branchId;
				this.payloads.typeId = parseData[0].typeId;
			}
			return cart_items;
		}
	},

	mounted() {
		if(_.isEmpty(JSON.parse(sessionStorage.getItem('promo')))) {
			swal.fire({
				title: 'Oooops!',
				text: 'Please select a promo first!',
				icon: 'error',
				showCancelButton: false,
                reverseButtons: true,
				confirmButtonText: 'Back to homepage'
			}).then(response => {
				window.location.href = '/';
			})
		}
		this.init();
	},

	methods: {
		init() {
			this.payloads.promoSelected = JSON.parse(sessionStorage.getItem('promo'));
			
			

			if(this.authenticated != '1') {
				// this.cart = .length ? JSON.parse(sessionStorage.getItem('cart_items')) : [];
				this.voucher = JSON.parse(sessionStorage.getItem('voucher'));
			}

			if(this.authenticated === '1') {
				var data = {
					items: this.computedCart,
					promoSelected: this.payloads.promoSelected
				}
				axios.post(this.guestUserCartUrl, data)
					.then(response => {
						sessionStorage.removeItem('cart_items')
						this.cart = response.data.cart;
						this.payloads.branchId = response.data.branch.id;
						this.payloads.branchSelected = response.data.branch;
						this.payloads.typeId = response.data.type.id;
						this.payloads.selectedType = response.data.type;
						this.payloads.grandTotal = response.data.cartTotal;
						if(!_.isEmpty(this.cart)) {
							if(sessionStorage.getItem('step')) {
								this.step = parseInt(sessionStorage.getItem('step'));
								this.payloads.selectedPayment = parseInt(sessionStorage.getItem('paymentMethod'));
							} else {
								this.step = 3;
							}
						}
					})
			}
		},

		nextForm() {
			this.step += 1;
		},

		backForm() {
			if(this.step === 3) {
				var data = {
					value: this.step
				}
				swal.fire({
					title: 'Are you sure?',
					text: 'Are you sure you want to go back? All your items will be removed.',
					icon: 'question',
					showCancelButton: true,
					reverseButtons: true,
					confirmButtonText: 'Confirm'
				}).then(result => {
                    if (result.value) {
                    	if(this.authenticated === '' || this.authenticated === null) {
                    		sessionStorage.removeItem('cart_items');
                    		this.cart = [];
            				this.$refs.bakingModal.init();
            				this.step -= 1;
                    	} else {
                    		axios.post(this.cartItemTruncateUrl, data)
                    			.then(response => {
                    				this.step -= 1;
                    				this.$refs.bakingModal.init();
                    			})	
                    	}
                    		
                	} else {
                		this.step = 3;
                	}
				})
				
			} else {
				this.step -= 1;
			}
		}
	}

	
}
</script>