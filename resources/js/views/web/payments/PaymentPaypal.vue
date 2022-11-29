<template>
	<div>
		<loading :active.sync="isLoading" 
		        :is-full-page="fullPage"></loading>
	</div>
</template>
<script>
	import prx_paypal_mixin from '../../../../../public/vendor/praxxys/ecommerce/paypal/js/vue-mixin.js';
	import Loading from 'vue-loading-overlay';
	import 'vue-loading-overlay/dist/vue-loading.css'; 

	export default{

		props: {
			reference_code: String,
			total: Number
		},

		data() {
			return {
				isLoading: true,
                fullPage: true
			}
		},

		mixins: [prx_paypal_mixin],

		components: {
            Loading
		},

		mounted() {
			setTimeout(() =>{ 
				this.processPayment();
			}, 3000);
		},	

		methods: {
			processPayment() {
				this.PRXPayPalSubmit(this.buildItems(), this.reference_code, 'PHP');
			},

			buildItems() {
				const items = []; 
				var total = parseFloat(this.total);
				items.push({name: 'BakeBe Reservation', price: total, qty: 1});
				return items;
			},
		}
	}
</script>