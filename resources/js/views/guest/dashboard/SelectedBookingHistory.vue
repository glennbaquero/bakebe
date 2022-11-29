<template>
	<div>
	<div class="frm-cntnr">
		<div class="w-90 mx-auto py-3">
			<div class="w-100 mb-5 inlineBlock-parent">
				<div class="w-50">
					<p class="text-muted selected--back"><span @click="$emit('backToHistory')"><i class="fas fa-chevron-left text-muted"></i> Back</span></p>	
				</div
				><div class="w-50 text-right">
					<button @click="print()" class="btn btn-light-brown px-3 py-0 rounded-btn text-white">Print</button>
				</div>
			</div>

			<div class="w-100 mt-5">
			</div>					

			<h5 class="text-primary font-weight-bold mb-2"># {{ item.reference_number }}</h5>
			<div class="w-100 inlineBlock-parent">
				<div class="w-50">

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted">Type of Booking:</p> <p class="text-muted">{{ item.book_type }}</p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted">Date:</p> <p class="text-muted">{{ item.created_at }}</p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted">Location:</p> <p class="text-muted">{{ item.branch }}</p>
					</div>
				</div
				><div class="w-50">
					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted">Payment Option:</p> <p class="text-muted">{{ item.payment_type_label }}</p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted">Voucher Code:</p> <p class="text-muted">{{ item.coupon_code }}</p>
					</div>

					<div class="w-100 inlineBlock-parent">
						<p class="mr-2 text-muted">Amount:</p> <p class="text-muted">P {{ item.total_payment}}</p>
					</div>
				</div>
			</div>


			<div id="printPastry" class="w-100 mt-4 desktop-show">
				<p class="text-muted">Pastries Booked:</p>
				<table class="table selected--table">
				  <thead>
				    <tr class="text-center">
				    	<th scope="col"></th>
				    	<th scope="col">Pastry</th>
				      	<th scope="col">Duration</th>
				      	<th scope="col">Difficulty</th>
				      	<th scope="col">Guest</th>
				      	<th scope="col">Date</th>
				      	<th scope="col">Time</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr class="text-center" v-for="invoiceItem in item.invoiceItems">
				      <td><img class="img-contain mr-2 sel-book__img" :src="invoiceItem.pastry_image" alt=""></td>
				      <td><small class="text-muted">{{ invoiceItem.pastry_name }}</small></td>
				      <td><small class="text-muted">{{ invoiceItem.pastry_duration }}</small></td>
				      <td><small class="text-muted">{{ invoiceItem.pastry_difficulty }}/5</small></td>
				      <td><small class="text-muted">{{ invoiceItem.attendees }}</small></td>
				      <td><small class="text-muted">{{ invoiceItem.formatted_schedule }}</small></td>
				      <td><small class="text-muted">{{ invoiceItem.formatted_time }}</small></td>
				    </tr>
				  </tbody>
				</table>
			</div>

			<!-- Mobile Responsive -->

			<div class="w-100 mt-5 mobile-show">
				<div class="w-100 inlineBlock-parent">
					<p>Pastries Booked:</p> 
				</div>

				<div class="w-100 mb-4">
					<p class="font-weight-bold mb-2">Pastry</p>

					<div class="divider w-100"></div>
				</div>

				<div class="w-100" v-for="(invoiceItem, key) in item.invoiceItems">
					<div class="inlineBlock-parent mb-3">
						<i class="fas fa-plus-circle mr-2 button--show text-orange" data-toggle="collapse" :data-target="'#demo-' + key"></i> <span><img class="img-contain mr-2 sel-book__img" :src="invoiceItem.pastry_image" alt=""> <small class="text-muted">{{ invoiceItem.pastry_name }}</small></span>
					</div>

					<div :id="'demo-' + key" class="collapse w-100">
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Duration</p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">{{ invoiceItem.pastry_duration }}</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Difficulty</p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">{{ invoiceItem.pastry_difficulty }}/5</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Guest</p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">{{ invoiceItem.attendees }}</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Date</p>
							</div
							><div class="w-50">	
								<p class="text-muted">{{ invoiceItem.formatted_schedule }}</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Time</p>
							</div
							><div class="w-50">
								<p class="text-muted">{{ invoiceItem.formatted_time }}</p>
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
import CrudMixin from 'Mixins/crud.js';
import ArrayHelpers from 'Mixins/array.js';

 	export default {

		props: {
			item: {},
			invoiceItem: {},			
			invoiceItems: [],				
			keyShow: null

		}, 		

		data () {
		     return {
		     output: null
		   }
		},

		 methods: {

	        print() {
	            let url = this.item.printInvoiceUrl,
	                win = window.open(url);
	            win.print();
	        },

			viewMore(key, show=true) {
				this.keyShow = key;
				
				if(!show) {
					this.keyShow = null;
				}
			}	        
		 },

		mounted() {
			this.invoiceItems = this.$parent._props.invoiceItems;
		},		 

	    mixins: [ CrudMixin, ArrayHelpers ],

	    computed: {
		    fetchParams() {
	            return {
	            	nopagination: 1,
	            	
	            };
	        },
	    },
	}

</script>