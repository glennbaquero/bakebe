<template>
	<!-- Modal -->
	<div class="modal fade login--modal" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<i class="far fa-times-circle close--modal text-primary" data-dismiss="modal"></i>
	    	<div class="w-90 mx-auto py-4">
	    		<div class="row mr-0 ml-0">
	            	<div class="col-12 px-0 pt-5 pb-4">
	            		<div class="vertical-parent">
	            			<div class="vertical-align">
	            				<div class="w-100 text-center">
	            					<div class="modal--icon mb-3" style="background-image: url('images/assets/user1.png')"></div>
	            					<p class="font-weight-bold text-primary appointment--desc mb-3">Oops! You haven't logged in yet</p>
	            					<p class="w-60 mx-auto">Kindly login or sign up for an account before proceeding.</p>
	            				</div>

	            				<div class="text-center w-100 inlineBlock-parent mt-4">
									<button class="btn btn-white pink-shadow font-weight-bold text-primary rounded-btn custom-btn mr-4 px-4 w-auto" @click="buttonClick('register')">
										SIGN UP 
									</button>
									<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" @click="buttonClick('login')">
										LOGIN
									</button>
								</div>
	            			</div>
	            		</div>
	            	</div>
	            </div>
	    	</div>
	    </div>
	  </div>
	</div>
</template>

<script>
	export default {
		methods: {
			buttonClick(url) {
				sessionStorage.setItem('paymentMethod', this.$parent.payloads.selectedPayment);
				sessionStorage.setItem('step', 5);
				window.location.href = url;
			}
		}
	}

</script>