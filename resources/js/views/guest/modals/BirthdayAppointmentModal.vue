<template>
	<!-- Modal -->
	<div class="modal fade appointment--modal" id="birthappointmentModal" tabindex="-1" role="dialog" aria-labelledby="birthappointmentModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	    	<i class="far fa-times-circle close--modal text-primary" @click="close()"></i>
            <div class="row mr-0 ml-0">
            	<div class="col-4 px-0 desktop-show">
            		<div class="modal--img" style="background-image: url('images/assets/product1.png')"></div>
            	</div>
            	<div class="col-md-8 col-sm-12 col-12 px-0">
            		<div class="vertical-parent">
            			<div class="vertical-align">
            				<div class="w-100 text-center">
            					<div class="modal--icon mb-3" style="background-image: url('images/assets/calcsuccess.png')"></div>
            					<p class="font-weight-bold text-primary appointment--desc">Earl Grey Chiffon Sandwiches has been successfully added to your appointment list</p>
            				</div>

            				<div class="text-center w-100 inlineBlock-parent mt-4">
								
								<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" @click="nextAction()">
									NEXT
								</button>
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

			close() {
				if($('.booking--modal').hasClass('show')) {
					$('.booking--modal').modal('toggle');
				}

				if($('.edit--booking--modal').hasClass('show')) {
					$('.edit--booking--modal').modal('toggle');
				}

				$('.appointment--modal').modal('toggle');
			},

			next() {
				if($('.booking--modal').hasClass('show')) {
					$('.booking--modal').modal('toggle');
				}

				if($('.edit--booking--modal').hasClass('show')) {
					$('.edit--booking--modal').modal('toggle');
				}

				$('.appointment--modal').modal('toggle');
			},

			nextAction() {
				if($('.booking--modal').hasClass('show')) {
					$('.booking--modal').modal('toggle');
				}

				if($('.edit--booking--modal').hasClass('show')) {
					$('.edit--booking--modal').modal('toggle');
				}
				$('.appointment--modal').modal('toggle');
				this.$nextTick(() => {
					this.$parent.step += 1;
				})
			}
		}

	}

</script>