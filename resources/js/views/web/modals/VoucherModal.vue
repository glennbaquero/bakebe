<template>
	<!-- Modal -->
	<div class="modal fade voucher--modal" id="voucherModal" tabindex="-1" role="dialog" aria-labelledby="bakingModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<i class="far fa-times-circle close--modal text-primary" data-dismiss="modal"></i>
	    	<div class="w-90 mx-auto py-5">
	    		<p class="font-weight-bold text-secondary mb-5 w-90">Have a BakeBe, Klook or Metro Deal voucher codes? Enter the promo code below</p>

	    		<text-field
	    		label="Promo code (Optional)"
				placeholder="Enter voucher code"
				class="text-muted"
	    		></text-field>

	    		<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn mt-3">
					APPLY
				</button>	
	    	</div>
	    </div>
	  </div>
	</div>
</template>

<script>
import TextField from '../../../components/inputs/TextField.vue';

	export default {
		components: {
			'text-field' : TextField,
		}
	}

</script>