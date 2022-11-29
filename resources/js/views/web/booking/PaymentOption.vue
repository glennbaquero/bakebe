<template>
	<div class="frm-cntnr mt-5">
		<div class="w-100">
			<p class="frm-title text-secondary mb-3">PAYMENT OPTION</p>
			<p class="mb-5">All transaction are secured and encrypted</p>	
		</div>

		<div class="w-100 paymnets-gateway__holder">
			<div class="row mb-5">
				<div class="col-md-4 col-sm-12 -col-12 payments-gateway">
					<span class="font-weight-bold"><input type="radio" class="mr-3">Paynamics</span>
				</div>
				<div class="col-md-8 col-sm-12 -col-12">
					<p>You will be redirected to Paynamics Payment Portal</p>
					<span><img class="payments--method img-contain" src="../../../../../public/images/assets/gcash.png" alt=""><img class="img-contain payments--method" src="../../../../../public/images/assets/visa.png" alt=""><img class="payments--method img-contain" src="../../../../../public/images/assets/master-card.png" alt=""></span>
				</div>
			</div>
			<div class="row mb-5">
				<div class="col-md-4 col-sm-12 -col-12 payments-gateway">
					<span class="font-weight-bold"><input type="radio" class="mr-3">Paypal</span>
				</div>
				<div class="col-md-8 col-sm-12 -col-12">
					<p>You will be redirected to Paypal Payment Portal</p>
					<span><img class="payments--method img-contain" src="../../../../../public/images/assets/visa.png" alt=""><img class="img-contain payments--method" src="../../../../../public/images/assets/master-card.png" alt=""><img class="payments--method img-contain" src="../../../../../public/images/assets/jcb.png" alt=""></span>
				</div>
			</div>
			<div class="row mb-5">
				<div class="col-md-4 col-sm-12 -col-12 payments-gateway">
					<span class="font-weight-bold"><input type="radio" class="mr-3">PayMaya</span>
				</div>
				<div class="col-md-4 col-sm-12 -col-12">
					<p>You will be redirected to PayMaya Payment Portal</p>
				</div>
			</div>
			<div class="divider w-100 mb-3"></div>
			<small data-toggle="modal" data-target="#voucherModal" class="text-pink voucher--text">Have a Bakebe, Klook or Metro Deal voucher codes?</small>
		</div>
	</div>
</template>
<script>

export default {

}
	
</script>