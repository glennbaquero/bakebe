<template>
	<!-- Modal -->
	<div class="modal fade baking--modal" id="bakingModal" tabindex="-1" role="dialog" aria-labelledby="bakingModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<div class="w-90 mx-auto py-4">
	    		<div class="row mr-0 ml-0">
	            	<div class="col-12 px-0">
	            		<h6 class="font-weight-bold mb-4">Baking Schedule</h6>
	            	</div>
	            </div>

	            <div class="row mr-0 ml-0" v-for="card in cards">
            		<div class="col-2 px-0">
            			<div class="product--modal-img" style="background-image: url('images/assets/product1.png')"></div>
            		</div>
            		<div class="col-6">
            			<div class="row mb-2">
							<div class="col-12">
								<small class="mb-0 font-weight-bold">Earl Grey Chiffon Sandwiches</small>
							</div>
						</div>
						<div class="row mb-3 card--modal-details">
							<div class="col-9">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="images/assets/clock.png" alt="">2 HOURS and 30 MINS</span></small>
							</div>
							<div class="col-3">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="images/assets/timer.png" alt="">3/5</span></small>
							</div>
						</div>
						<div class="row mb-4 card--modal-details">
							<div class="col-9">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="images/assets/calendar.png" alt="">February 21, 2020 at 10:30 AM</span></small>
							</div>
							<div class="col-3">
								<small class="text-light-brown font-weight-bold"><span><img class="img-contain booking-icon mr-2" src="images/assets/user2.png" alt="">1</span></small>
							</div>
						</div>
            		</div>
            		<div class="col-4 text-right">
            			<div class="inlineBlock-parent mb-4">
            				<button class="btn btn-pink custom--btn py-0 w-auto mr-2">
            					<span><i class="fas fa-pen mr-1"></i> Edit</span>
            				</button>
            				<button class="btn btn-orange custom--btn py-0 w-auto">
            					<span><i class="fas fa-trash-alt"></i> Remove</span>
            				</button>
            			</div>

            			<small class="font-weight-bold">P 2,500.00</small>
            		</div>
            	</div>
            	<div class="divider mb-4"></div>

            	<div class="row">
            		<div class="col-6">
            			<p class="font-weight-bold text-primary">Total</p>
            		</div>
            		<div class="col-6 text-right">
            			<p class="font-weight-bold text-primary">P 5,000.00</p>
            		</div>
            	</div>
            	<div class="row mt-2">
            		<div class="col-12 text-center">
            			<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn">
							NEXT
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
		data: function() {

			return {
				cards: 2,
			}
		}

	}

</script>