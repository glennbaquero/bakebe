<template>
	<div class="frm-cntnr">
		<div class="w-90 mx-auto py-3">
			<p class="text-primary font-weight-bold mb-0">BOOKING HISTORY</p>
			<small class="text-muted">Book another baking schedule</small>
			<div class="w-100 mt-3">
				<button class="btn btn-primary rounded-btn font-weight-bold">BOOK NOW</button>
			</div>		


			<div class="w-100 mt-4 desktop-show">
				<table class="table">
				  <thead>
				    <tr class="text-center">
				      	<th scope="col">Pastry</th>				    	
				      	<th scope="col">Duration</th>
				      	<th scope="col">Difficulty</th>
				      	<th scope="col">Guest</th>
				      	<th scope="col">Date</th>
				      	<th scope="col">Time</th>	
				    </tr>
				  </thead>
				  <tbody>
				    <tr class="text-center" v-for="item in items">
				      <td><small class="text-muted">{{ item.pastry_image }} {{ item.pastry }}</small></td>				    	
				      <td><small class="text-muted">{{ item.duration }} </small></td>
				      <td><small class="text-muted">{{ item.difficulty }}/5</small></td>				      
				      <td><small class="text-muted">{{ item.guest }}</small></td>
  				      <td><small class="text-muted">{{ item.date }}</small></td>
				      <td><small class="text-muted">{{ item.time }}</small></td>				      
				    </tr>
				  </tbody>
				</table>
			</div>

			<div class="w-100 mt-5 mobile-show" v-for="item in items">
				<div class="w-100 inlineBlock-parent">
					<div class="sort--img img-contain mr-2" style="background-image: url('./images/assets/sort.png')"></div> <p class="text-light-brown">Sort</p> 
				</div>

				<div class="w-100 mb-4">
					<p class="font-weight-bold mb-2">Booking Date</p>

					<div class="divider w-100"></div>
				</div>

				<div class="w-100">
					<div class="inlineBlock-parent mb-3">
						<i class="fas fa-plus-circle mr-2 button--show text-orange" data-toggle="collapse" data-target="#demo"></i><small class="text-muted mb-0">Feb-03-2020</small>
					</div>

					<div id="demo" class="collapse w-100">
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">No. of Pastry </p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">2</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Reference No.</p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">BBR123456029</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Status</p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">Paid</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Actions</p>
							</div
							><div class="w-50">
								<button class="btn btn-primary px-2 py-0 rounded-btn"><small><i class="fas fa-eye"></i> View</small></button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Selector from '../../../components/inputs/Select.vue';
import CrudMixin from '../../../mixins/crud.js';
import ArrayHelpers from '../../../mixins/array.js';

	export default {
		components: {
			'select-fields' : Selector,
		},

		methods: {
			
			fetchSuccess(data) {	
				this.items = data.items ? data.items : this.items;
			},			
		},

		data() {

			return {
				items: {},

			}

		},

	    mixins: [ CrudMixin, ArrayHelpers ],

	    computed: {
		    fetchParams() {
	            return {
	            	nopagination: 1,
	            	
	            };
	        },

	    }

	}

</script>