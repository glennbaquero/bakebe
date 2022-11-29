<template>
	<form ref="paymaya" :action="url" method="POST" name="paymaya1">
	    <input type="hidden" name="total_payment" :value="total_payment">
	    <input type="hidden" name="voucher" :value="voucher">
	</form>
</template>

<script>
export default {
	methods: {
		submit() {
			setTimeout(() => {
				this.$refs['paymaya'].submit();
			}, 500);
		},

		setVars(url, total_payment, voucher) {
			this.url = url;
			this.total_payment = total_payment;
			this.voucher = JSON.stringify(voucher);
		},
	},

	data() {
		return {
			url: null,
			total_payment: null,
			voucher: {},
		}
	},
}
</script>