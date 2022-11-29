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
					<small class="text-pink font-weight-bold">{{ payloads.branchSelected.name }}</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-md-2 col-sm-3 col-3">
					<small class="text-muted">Type of Booking</small>
				</div>
				<div class="col-md-10 col-sm-9 col-9">
					<small class="text-pink font-weight-bold">{{ payloads.selectedType.name }}</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-12 mb-2">
					<small class="text-muted">Baking Schedule</small>
				</div>
				
				<div class="sched--holder inlineBlock-parent">
					<div v-for="item in items" class="col-md-3 col-sm-12 col-12 px-4 py-4 shadow summary--card shadown mb-3 mr-3">
						<i class="far fa-times-circle close--card text-primary" v-if="items.length > 1" @click="removeItem(item)"></i>
						<div class="row mb-4">
							<div class="col-12">
								<small class="text-muted"><span><img class="img-contain summary-icon mr-2" :src="item.selectedPastry.image_path" alt="">{{ item.selectedPastry.name }}</span></small>
							</div>
						</div>
						<div class="row mb-3 card--details">
							<div class="col-9">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="images/assets/clock.png" alt="">{{ duration(item.selectedPastry) }}</span></small>
							</div>
							<div class="col-3">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="images/assets/timer.png" alt="">{{ item.selectedPastry.difficulty }}</span></small>
							</div>
						</div>
						<div class="row mb-4 card--details">
							<div class="col-9">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="images/assets/calendar.png" alt="">{{ toDate(item.dateSelected) }} at {{ toTime(item.selectedTime, 'hh:mm A') }}</span></small>
							</div>
							<div class="col-3">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="images/assets/user2.png" alt="">{{ item.attendees }}</span></small>
							</div>
						</div>
						<div class="row">
							<div class="col-12">
								<small class="mb-0 font-weight-bold">{{ toMoney(item.totalPayment) }}</small>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row my-4">
				<div class="col-2">
					<small class="text-muted">Total Cart</small>
				</div>
				<div class="col-10">
					<small class="text-pink font-weight-bold">{{ toMoney(cartTotal) }}</small>
				</div>
			</div>
			<div class="divider w-100"></div>
			<div class="row my-4">
				<div class="col-2">
					<small class="text-muted">Voucher Discount</small>
				</div>
				<div class="col-10">
					<small class="text-pink font-weight-bold">{{ toMoney(voucherDiscount) }}</small>
				</div>
			</div>
			<div class="divider w-100"></div>
			<template v-if="selectedPromo.promo_category_id != 3">
				<div class="row my-4">
					<div class="col-2">
						<small class="text-muted">Promo Discount</small>
					</div>
					<div class="col-10">
						<small class="text-pink font-weight-bold">{{ promoDiscount }}</small>
					</div>
				</div>
				<div class="divider w-100"></div>
			</template>
			<div class="row my-4">
				<div class="col-2">
					<small class="text-muted">Total</small>
				</div>
				<div class="col-10">
					<small class="text-pink font-weight-bold">{{ toMoney(grandTotal) }}</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-2">
					<small class="text-muted">Voucher Code</small>
				</div>
				<div class="col-10">
					<small class="text-pink font-weight-bold">{{ voucherCode }}</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-2">
					<small class="text-muted">Promo</small>
				</div>
				<div class="col-10">
					<small class="text-pink font-weight-bold">{{ selectedPromo.name }}</small>
				</div>
			</div>
			<div class="divider w-100"></div>

			<div class="row my-4">
				<div class="col-md-2 col-sm-3 col-3">
					<small class="text-muted">Payments Method</small>
				</div>
				<div class="col-md-10 col-sm-9 col-9">
					<small class="text-pink font-weight-bold">{{ paymentMethod }}</small>
				</div>
			</div>
			<div class="divider w-100"></div>
<!-- 
			<div class="row my-4">
				<div class="col-12">
					<small class=""><span class="checkbox--holder"><input type="checkbox" v-model="isAgreeToTermsAndPolicy" checked="checked" class="mr-3"><span class="checkbox"></span>By ticking this box, you agree to our <a class="text-pink" href="#" data-toggle="modal" data-target="#termsModal">Terms of Conditions</a> and that you have read our <a class="text-pink" href="#" data-toggle="modal" data-target="#privacyTermsModal">Privacy Policy</a></span></small>
				</div>			
				
			</div>
 -->
			<div class="row my-6">
				<div class="col-12">
					<div class="inlineBlock-parent">
						<button class="btn btn-outlined-white shadow font-weight-bold text-primary rounded-btn px-4 mr-2" @click="backAction()">
							BACK
						</button>
						 <!-- @click="checkout()" v-if="isAgreeToTermsAndPolicy" -->
						<button class="btn btn-primary font-weight-bold text-white px-4 rounded-btn" data-toggle="modal" data-target="#termsModal">
							CHECKOUT
						</button>
					</div>
				</div>
			</div>			

		</div>
		<loading 
			:active.sync="isLoading" 
	        :is-full-page="true"
	        color="#e8627c"
		></loading>
		<terms-modal @accceptAndContinue="checkout()"></terms-modal>
		<paymaya-form
			ref="paymaya-form"
		></paymaya-form>
		<paynamics-form
			ref="paynamics-form"
		></paynamics-form>

	</div>
</template>

<script>
	import DateMixins from 'Mixins/date.js';
	import NumberMixins from 'Mixins/number.js';
	import PaymayaForm from '../payments/PaymayaForm.vue';
	import PaynamicsForm from '../payments/PaynamicsForm.vue';
	import Loading from 'vue-loading-overlay';
	import 'vue-loading-overlay/dist/vue-loading.css';
	import TermsModal from '../modals/TermsModal.vue';
	import prx_paypal_mixin from '../../../../../public/vendor/praxxys/ecommerce/paypal/js/vue-mixin.js'; 

	export default {

		mixins: [ DateMixins, NumberMixins, prx_paypal_mixin],

		components: {
			PaymayaForm,
			PaynamicsForm,
			Loading,
			TermsModal,
		},

		data() {
			return {
				isLoading: false,
				isAgreeToTermsAndPolicy: false,
				grandTotal: 0,
				termsConditionText: this.$parent.termsConditionText,
				voucherDiscount: 0
			}
		},

		computed: {
			items() {
				return this.$parent.cart;
			},

			payloads() {
				return this.$parent.payloads;
			},

			voucher() {
				return this.$parent.voucher;
			},

			selectedPromo() {
				return this.payloads.promoSelected;
			},

			voucherCode() {
				var result = this.voucher.code;

				if(_.isEmpty(this.voucher)) {
					result = '---';
				}
				return result;
			},

			// grandTotal() {
				
			// },

			paymentMethod() {
				var label = null;

				switch(this.payloads.selectedPayment) {
					case 0:
						label = 'Paypal'
						break;
					case 1: 
						label = 'Paynamics'
						break;
					case 2: 
						label = 'Paymaya'
						break;
				}

				return label;
			},

			paymentUrl() {
				var url = null;

				switch(this.payloads.selectedPayment) {
					case 0:
						url = this.$parent.paypalUrl;
						break;
					case 1: 
						url = this.$parent.paynamicsUrl;
						break;
					case 2: 
						url = this.$parent.paymayaUrl;
						break;
				}

				return url;
			},

			promoDiscount() {
				var label = 0;

				if(this.selectedPromo.is_percentage) {
					label = this.selectedPromo.discount+'%';
				} else {
					var total = 0;
					var attendees = 0;

					_.each(this.items, (item) => {
						attendees += item.attendees;
					});

					total = attendees * parseFloat(this.selectedPromo.discount);
					label = this.toMoney(total);
				}

				// if(this.selectedPromo.promo_category_id === 3) {
				// 	label = ''
				// }

				return label;
			},

			cartTotal() {
				var total = 0;

				_.each(this.items, (item) => {
					total += parseFloat(item.totalPayment);
				});

				return total;
			}
		},

		mounted() {
			this.setupGrandTotal();
			sessionStorage.removeItem('cart_items');
			sessionStorage.removeItem('voucher');
			sessionStorage.removeItem('step');
			sessionStorage.removeItem('paymentMethod');
		},

		methods: {

			setupGrandTotal() {
				this.isLoading = true;
				var code = this.voucher ? this.voucher.code : null;
				var promo = this.selectedPromo;
				axios.post(this.$parent.couponDiscountUrl, { code: code, promoSelected: promo })
					.then(response => {
						this.grandTotal = response.data.grand_total;
						this.voucherDiscount = response.data.coupon_total;
						this.isLoading = false;
					})
			},

			init() {
				var data = {
					grand_total: this.grandTotal
				};

				axios.post(this.$parent.cartUpdateUrl, data)
					.then(response => {

					})
			},

			duration(pastry) {
				var duration = pastry.duration;

				if(this.payloads.selectedType.id === 2) {
					duration = pastry.express_duration;
				} else {
					duration = pastry.duration_label;
				}

				return duration;
			},

			removeItem(item) {
				axios.post(item.removeItemUrl)
					.then(response => {
						this.$parent.cart = response.data.cart;
						this.payloads.grandTotal = response.data.cartTotal;
						this.setupGrandTotal();
						if(!this.$parent.cart.length) {
							
						}
					});
			},

			checkout() {
				this.isLoading = true;

				this.init();

				var payloads = {
					paymentMethod: this.payloads.selectedPayment,
					totalPayment: this.grandTotal
				}
				
                switch(this.payloads.selectedPayment) {
                	case 0:
                		this.paymentRedirectToPaypal();
                		break;
                	case 1: 
                		this.paymentRedirectToPaynamics();
                		break;
                	case 2: 
						this.paymentRedirectToPaymaya();
                		break;
                }
			},

			paymentRedirectToPaymaya() {
				let form = this.$refs['paymaya-form'];
				form.setVars(this.paymentUrl, this.grandTotal, this.voucher);
	            form.submit();
			},

			paymentRedirectToPaynamics() {
				var data = {
					id: this.payloads,
					voucher: this.voucher,
					grand_total: this.grandTotal
				};

				axios.post(this.paymentUrl, data)
					.then(response => {
						var data = response.data;
                        let form = this.$refs['paynamics-form'];
                        form.setVars(data.gateway_url, data.signature);
                        form.submit();
					})
			},

			paymentRedirectToPaypal() {

				var data = {
					id: this.payloads,
					voucher: this.voucher,
					grand_total: this.grandTotal
				};

				axios.post(this.paymentUrl, data)
					.then(response => {
						this.PRXPayPalSubmit(this.buildItems(), response.data.reference_number, response.data.currency);

					})

			},

			buildItems() {
			    const items = []; 
			    var total = this.grandTotal;
			    items.push({name: 'Reservation', price: total, qty: 1});
			    return items;
			},			

			backAction() {
				this.$parent.step -= 1;
			}
		}
	}
</script>