<template>
	<div class="frm-cntnr">
		<div class="w-90 mx-auto py-3">
			<p class="text-primary font-weight-bold mb-0">Selected BOOKING HISTORY</p>
			<small class="text-muted">Book another baking schedule</small>


			<div class="w-100 mt-4 desktop-show">
				<table class="table">
				  <thead>
				    <tr class="text-center">
				    	<th scope="col">Booking Date</th>
				      	<th scope="col">No. of Pastry</th>
				      	<th scope="col">Reference No.</th>
				      	<th scope="col">Status</th>
				      	<th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr class="text-center">
				      <td><small class="text-muted">Feb-03-2020</small></td>
				      <td><small class="text-muted">2</small></td>
				      <td><small class="text-muted">BBR123456029</small></td>
				      <td><small class="text-muted">Paid</small></td>
				      <td><button class="btn btn-primary px-2 py-0 rounded-btn"><small><i class="fas fa-eye"></i> View</small></button></td>
				    </tr>
				  </tbody>
				</table>
			</div>

			<div class="w-100 mt-5">
				<div class="w-100 inlineBlock-parent">
					<img class="img-contain mr-2" src="images/assets/sort 1.png" alt=""> <p class="text-light-brown">Sort</p> 
				</div>

				<div class="w-100">
					<p class="font-weight-bold mb-2">Booking Date</p>

					<div class="divider w-100"></div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
// import Selector from '../../../components/inputs/Select.vue';

// 	export default {
// 		components: {
// 			'select-fields' : Selector,
// 		},

// 		data: function() {

// 			return {
// 				recents: [{id: '1', recent: 'recent 1'}, {id: '2', recent: 'recent 2'}],
// 				status: [{id: '1', state: 'Paid'}, {id: '2', state: 'Cancelled'}]
// 			}

// 		}
// 	}

</script>