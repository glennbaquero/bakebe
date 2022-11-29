<template>
	<!-- Modal -->
	<div class="modal fade terms--modal" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<i class="far fa-times-circle close--modal text-primary" data-dismiss="modal"></i>
	    	<div class="w-90 mx-auto py-5">
	    		<div class="row mb-5">
	    			<div class="col-12 text-center">
	    				<h6 class="font-weight-bold mt-5 text-primary">Terms and Conditions</h6>	
	    			</div>			
	    		</div>

	    		<div class="row moda--body">
	    			<div class="col-12 terms--desc scroll-custom" v-html="$parent.termsConditionText">
	    			</div>
	    		</div>

	    		<div class="row mt-3">
	    			<div class="col-12 text-center">
	    				<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn mt-3 w-auto px-3 accept--btn" data-toggle="modal" data-target="#termsModal" :disabled="isDisabled" @click="$emit('accceptAndContinue')">
							ACCEPT & CONTINUE
						</button>
	    			</div>	
	    		</div>
	    	</div>
	    </div>
	  </div>
	</div>
</template>

<script>
	export default {
		data() {
			return {
				isDisabled: true
			}
		},

		mounted() {
			var $this = this;
			$('.terms--desc').scroll(function() {

				console.log(($(this).scrollTop() + $(this).innerHeight()) == ($(this)[0].scrollHeight), ($(this).scrollTop() + $(this).innerHeight()), ($(this)[0].scrollHeight))

			  	if(($(this).scrollTop() + $(this).innerHeight()) >= ($(this)[0].scrollHeight)) {
			  		$this.isDisabled = !$this.isDisabled;
			  	} else {
			  		$this.isDisabled = true;
			  	} 
			});
		},
	}

</script>