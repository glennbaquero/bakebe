<template>
	<div class="frm-cntnr">
		<div class="w-90 mx-auto py-3">
			<p class="text-primary font-weight-bold mb-0">BOOKING HISTORY</p>
			<small class="text-muted">Book another baking schedule</small>
			<div class="w-100 mt-3">
				<button class="btn btn-primary rounded-btn font-weight-bold">BOOK NOW</button>
			</div>			

			<div class="w-100 booking--history mt-5 desktop-inline-show">
				<div class="row">
					<div class="col-2 align-self-center">
						<small>Sort by:</small>
					</div>
					<div class="col-3 align-self-center">
						<select-fields
						@change="filterRecent"
						:items="recents"
						item-value="value"
						item-text="recent"
						placeholder="Most recent"
						>
						</select-fields>
					</div>
					<div class="col-2 align-self-center">
						<select-fields
						@change="filterStatus"
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
				      	<th scope="col">Status</th>
				      	<th scope="col">Date</th>
				      	<th scope="col">Actions</th>
				    </tr>
				  </thead>
				  <tbody>
				    <tr class="text-center" v-for="item in items">
				      <td><small class="text-muted">{{ item.reference_number }} </small></td>
				      <td><small class="text-muted">{{ item.cart_id }} </small></td>
				      <td><small class="text-muted">{{ item.payment_status_label }}</small></td>
				      <td><small class="text-muted">{{ item.created_at }}</small></td>
				      <td><button class="btn btn-primary px-2 py-0 rounded-btn" @click="$emit('selectedBooking', item)"><small><i class="fas fa-eye"></i> View</small></button></td>
				    </tr>
				  </tbody>
				</table>
			</div>

			<div class="w-100 mt-5 mobile-show">
				<div class="w-100 inlineBlock-parent">
					<div class="sort--img img-contain mr-2" @click="filterRecent('asc')" style="background-image: url('./images/assets/sort.png')"></div> <p class="text-light-brown">Sort</p> 
				</div>

				<div class="w-100 mb-4" >
					<p class="font-weight-bold mb-2"> Booking Reference Number </p>

					<div class="divider w-100"></div>
				</div>

				<div class="w-100" v-for="(item, key) in items">
					<div class="inlineBlock-parent mb-3">
						<i class="fas fa-plus-circle mr-2 button--show text-orange" data-toggle="collapse" :data-target="'#demo-' + key"></i><small class="text-muted mb-0">{{ item.reference_number }}</small>
					</div>

					<div :id="'demo-' + key" class="collapse w-100">
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0"> No. Of Pastry </p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">{{ item.cart_id }}</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Total Payment</p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">{{ item.total_payment }}</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Status</p>
							</div
							><div class="w-50">
								<p class="mb-0 text-muted">{{ item.payment_status_label }}</p>
							</div>
						</div>
						<div class="w-90 inlineBlock-parent ml-auto mr-0 mb-3">
							<div class="w-50">
								<p class="font-weight-bold mb-0">Actions</p>
							</div
							><div class="w-50">
								<button class="btn btn-primary px-2 py-0 rounded-btn" @click="$emit('selectedBooking', item)"><small><i class="fas fa-eye"></i> View</small></button>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</template>

<script>
import Selector from 'Components/inputs/Select.vue';
import CrudMixin from 'Mixins/crud.js';
import ArrayHelpers from 'Mixins/array.js';

	export default {
		components: {
			'select-fields' : Selector,
		},

		methods: {
			
			fetchSuccess(data) {	
				this.items = data.items ? data.items : this.items;

			},			

			filterStatus(e) {

				this.params.is_paid = e;
				this.fetch();
			},

			filterRecent(e) {

				this.params.sortBy = e;
				this.fetch();
			},

		},

		data() {

			return {
				items: [],
				item: {},
				recents: [{value: 'desc', recent: 'Newest'}, {value: 'asc', recent: 'Oldest'}],
				status: [{id: '2', state: 'All'}, {id: '1', state: 'Paid'}, {id: '0', state: 'Pending'}],
				keyShow: null,				
				params: { 
					nopagination: 1, 
					
				},
			}

		},

		mounted() {
			this.items = this.$parent._props.items;
		},

	    mixins: [ CrudMixin, ArrayHelpers ],

	    computed: {
		    fetchParams() {
	            return  this.params;
	        },

	    }

	}

</script>