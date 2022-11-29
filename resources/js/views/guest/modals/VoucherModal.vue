<template>
	<!-- Modal -->
	<div class="modal fade voucher--modal" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="bakingModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<i class="far fa-times-circle close--modal text-primary" data-dismiss="modal"></i>
	    	<div class="w-90 mx-auto py-5">
	    		<p class="font-weight-bold text-secondary mb-5 w-90">Have a coupon? Enter the promo code below</p>

	    		<text-field
	    		label="Promo code (Optional)"
				placeholder="Enter voucher code"
				class="text-muted"
				v-model="code"
	    		></text-field>

	    		<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn mt-3" @click="verifyVoucher()">
					APPLY
				</button>	
	    	</div>
	    </div>
	  </div>
	</div>
</template>

<script>
import TextField from 'Components/inputs/TextField.vue';
import ErrorResponse from 'Mixins/errorResponse.js';

	export default {
		props: {
			voucherCheckerUrl: String
		},

		data() {
			return {
				code: null
			}
		},

		computed: {
			totalInvoice() {
				var result = 0;

				_.each(this.$parent.cart, (cart) => {
					result += parseFloat(cart.totalPayment);
				})

				return result;
			}
		},

		components: {
			'text-field' : TextField,
		},

		mixins: [ ErrorResponse ],

		mounted() {
			if(!_.isEmpty(JSON.parse(sessionStorage.getItem('voucher')))) {
				var voucher = JSON.parse(sessionStorage.getItem('voucher'));
				this.code = voucher.code;
				this.$parent.voucher = voucher;
			}
		},

		methods: {
			verifyVoucher() {
				var data = {
					code: this.code,
					invoice_total: this.totalInvoice
				};

				axios.post(this.voucherCheckerUrl, data)
					.then(response => {
						this.$parent.voucher = response.data.coupon;
						sessionStorage.setItem('voucher', JSON.stringify(response.data.coupon))
						swal.fire(
						      'Hoooray!',
						      'Coupon is updated',
						      'success'
						    );
					})
					.catch(errors => {
						swal.fire(
						      'Ooops!',
						      this.parseError(errors),
						      'error'
						    );	
					})
			}
		}
	}

</script>