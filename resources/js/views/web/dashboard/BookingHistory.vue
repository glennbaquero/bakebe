<!-- <template>
	<div class="frm-cntnr">
		<div class="w-90 mx-auto py-3">
			<p class="text-primary font-weight-bold mb-0">BOOKING HISTORY</p>
			<small class="text-muted">Book another baking schedule</small>
			<div class="w-100 mt-3">
				<button class="btn btn-primary rounded-btn font-weight-bold">BOOK NOW</button>
			</div>

			<div class="w-100 mt-5 desktop-inline-show">
				<div class="row">
					<div class="col-2">
						<small>Sort by:</small>
					</div>
					<div class="col-3">
						<select-fields
						:items="recents"
						item-value="id"
						item-text="recent"
						placeholder="Most recent"
						>
						</select-fields>
					</div>
					<div class="col-2">
						<select-fields
						:items="status"
						item-value="id"
						item-text="state"
						placeholder="Status"
						>
						</select-fields>
					</div>
				</div>
			</div>

			<div class="w-100 mt-4 desktop-show">
				<table class="table">
				  <thead>
				    <tr class="text-center">

				      	<th scope="col">Reference No.</th>				    	
				      	<th scope="col">No. of Pastry</th>
				      	<th scope="col">Total Amount</th>
				      	<th scope="col">Status</th>
				      	<th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr class="text-center" v-for="item in items">
				      <td><small class="text-muted">{{ item.reference_number }}</small></td>				    	
				      <td><small class="text-muted">{{ item.cart_id }} </small></td>
				      <td><small class="text-muted">{{ item.total_payment }} </small></td>				      
				      <td><small class="text-muted">{{ item.payment_status_label }}</small></td>
<<<<<<< HEAD
				      <td><view-button class="btn btn-primary px-2 py-0 rounded-btn" :href="item.showUrl">View</view-button></td>
=======
				      <td><button class="btn btn-primary px-2 py-0 rounded-btn" @click="$emit('selectedBooking', item)"><small><i class="fas fa-eye"></i> View</small></button></td>
>>>>>>> dfb35b44f5704683600cf53af2c0fb65b1b89966
				    </tr>
				  </tbody>
				</table>
			</div>

			<div class="w-100 mt-5 mobile-show">
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
import ViewButton from 'Components/buttons/ViewButton.vue';


	export default {
		components: {
			'select-fields' : Selector,
	        'view-button': ViewButton,

		},

		methods: {
			
			fetchSuccess(data) {	
				this.items = data.items ? data.items : this.items;
			},			
		},

		data() {

			return {
				items: {},
				recents: [{id: '1', recent: 'recent 1'}, {id: '2', recent: 'recent 2'}],
				status: [{id: '1', state: 'Paid'}, {id: '2', state: 'Cancelled'}]
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

</script> -->