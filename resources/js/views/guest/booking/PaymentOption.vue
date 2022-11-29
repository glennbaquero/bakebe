<template>
	<div class="frm-cntnr mt-5">
		<div class="w-100">
			<p class="frm-title text-secondary mb-3">PAYMENT OPTION</p>
			<p class="mb-5">All transaction are secured and encrypted</p>	
		</div>

		<div class="w-100 paymnets-gateway__holder">
			<div class="row mb-5" v-if="showPaynamics">
				<div class="col-md-4 col-sm-12 col-12">
					<span class="font-weight-bold"><input type="radio" class="mr-3" v-model="payloads.selectedPayment" :value="1">Paynamics</span>
				</div>
				<div class="col-md-8 col-sm-12 col-12">
					<p>You will be redirected to Paynamics Payment Portal</p>
					<span><img class="img-contain paynamics--logo" src="/images/newpaynamics-logo.png" alt=""></span>
				</div>
			</div>
			<div class="row mb-5">
				<div class="col-md-4 col-sm-12 col-12">
					<span class="font-weight-bold"><input type="radio" class="mr-3" v-model="payloads.selectedPayment" :value="0">Paypal</span>
				</div>
				<div class="col-md-8 col-sm-12 col-12">
					<p>You will be redirected to Paypal Payment Portal</p>
					<span><img class="payments--method img-contain" src="/images/assets/visa.png" alt=""><img class="img-contain payments--method" src="/images/assets/master-card.png" alt=""><img class="payments--method img-contain" src="/images/assets/jcb.png" alt=""></span>
				</div>
			</div>
			<!-- <div class="row mb-5">
				<div class="col-md-4 col-sm-12 col-12">
					<span class="font-weight-bold"><input type="radio" class="mr-3" v-model="payloads.selectedPayment" :value="2">PayMaya</span>
				</div>
				<div class="col-md-4 col-sm-12 col-12">
					<p>You will be redirected to PayMaya Payment Portal</p>
				</div>
			</div> -->
			<div class="divider w-100 mb-3"></div>
			<small data-toggle="modal" data-target="#voucherModal" class="text-pink voucher--text">Have a voucher codes?</small>
		</div>
	</div>
</template>
<script>

export default {
	props: {
		payloads: Object
	},

	data() {
		return {
			showPaynamics: true
		}
	},

	mounted() {
		var computedcart = this.$parent.computedCart
		var items = _.filter(this.$parent.cart, (item) => {
			var threeDays = moment().add(3, 'days');
            var today = moment();
            var selected = moment(item.dateSelected)
            return moment(selected).isBetween(today, threeDays);
        });
        console.log(items);
		this.showPaynamics = items.length ? false : true;
	}

}
	
</script>