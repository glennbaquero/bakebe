<template>
	<!-- Modal -->
	<div class="modal fade booking--modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
            <div class="row">
            	<div class="col-5 bg-primary pr-0">
            		<div class="modal--img" style="background-image: url('images/assets/product1.png')"></div>
					<!-- <img class="img-contain modal--img" src="images/assets/product1.png" alt=""> -->

					<div class="w-85 mx-auto mt-3 time--holder pb-5">
						<h5 class="font-weight-bold text-white">P 2,500.00</h5>
						<p class="text-white">Earl Grey Chiffon Sandwiches</p>
						<div class="row mb-3">
							<div class="col-8">
								<span><img class="modal--icon img-contain mr-2" src="images/assets/clock.png" alt=""><small class="font-weight-bold text-white">2 HOURS 30 MINS</small></span>	
							</div>
							<div class="col-4 text-right">
								<span><img class="modal--icon img-contain mr-2" src="images/assets/timer.png" alt=""><small class="font-weight-bold text-white">3/5</small></span>
							</div>
						</div>

						<small class="mb-0 text-white modal--desc">Dreamy strawberry cream fillings | We all know that macarons are delicate pastries, a sweet meringue-based confection made with finely ground almonds. Our starry night macarons is filled with strawberry butter cream. How refreshing!</small>
						
					</div>            		
            	</div>
            	<div class="col-7 px-0 shadow">
            		<div class="w-85 mx-auto py-5">
            			<h6 class="font-weight-bold mb-4">How many are attending?</h6>
						<div class="row mb-3">
							<div class="col-4 pr-0">
								<small class="mb-0">Number of persons</small>	
							</div>
							<div class="col-2 px-0">
								<number-field
								class="modal--num-field"
								></number-field>	
							</div>
							<div class="col-6">
								<small class="max--number text-light-brown">Max. of 2 persons</small>
							</div>
						</div>
						<h6 class="font-weight-bold">Choose your appointment schedule</h6>
						
						<div class="row">
							<div class="col-8">
								<datepicker></datepicker>
							</div>
							<div class="col-4">
								<div class="vertical-parent">
									<div class="vertical-align">
										<div class="inlineBlock-parent">
											<div class="modal--dot bg-primary"></div>
											<small class="max--number font-weight-bold">CHOSEN DATE</small>
										</div>

										<div class="inlineBlock-parent">
											<div class="modal--dot bg-light-gray"></div>
											<small class="max--number font-weight-bold">FULL BOOKED</small>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-3 pr-0">
								<small class="mb-0">Available time:</small>
							</div>
							<div class="col-3 px-0">
								<select-field 
								class="modal--time"
								:items="times"
								item-value="id"
								item-text="time"
								></select-field>
							</div>
							<div class="col-6"></div>
						</div>
						<div class="row mt-1">
							<div class="col-12">
								<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" data-toggle="modal" data-target="#appointmentModal">
									BOOK
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
import NumberField from '../../../components/inputs/NumberField.vue';
import Datepicker from '../../../components/datepickers/Datepicker.vue';
import SelectField from '../../../components/inputs/Select.vue';
import AppointmentModal from '../modals/AppointmentModal.vue';

	export default {
		components: {
			'number-field' : NumberField,
			'datepicker' : Datepicker,
			'select-field' : SelectField,
			'appointment-modal' : AppointmentModal
		}, 
		mounted() {
			$('.flatpickr-input').flatpickr({ inline:true })
		},

		data: function() {

			return {
				times: [{id: '1', time: '10:30 AM'}, {id: '2', time: '12: 30 PM'}]
			}
		}
	}

</script>