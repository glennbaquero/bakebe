<template>
	<!-- <form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success> -->
	<div>
		<card>
			<template v-slot:header> Basic Information </template>
			<br>
			<div class="row">
				<div class="form-group col-sm-12 col-md-4">
					<label>Reference Number : </label>
					<span class="badge bg-primary">{{ item.reference_number }}</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Branch : </label>
					<span class="badge bg-primary">{{ item.branch }}</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Booking Type : </label>
					<span class="badge bg-primary">{{ item.booking_type }}</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Name : </label>
					<span class="badge bg-secondary">{{ item.name }}</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Email : </label>
					<span class="badge bg-secondary">{{ item.email }}</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Contact Number : </label>
					<span class="badge bg-secondary">{{ item.mobile_number }}</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Total Discount : </label>
					<span class="badge bg-secondary">{{ item.discount }}</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Total Payment : </label>
					<span class="badge bg-secondary">{{ item.formatted_payment }}</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Payment Type : </label>
					<span class="badge" :class="item.payment_type_class">
                        {{ item.payment_type_label }}
                    </span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Payment Status : </label>
					<span class="badge" :class="item.payment_status_class">
					    {{ item.payment_status_label }}
					</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Coupon Code : </label>
					<span class="badge" :class="item.payment_status_class">
					    {{ item.code }}
					</span>
				</div>
				<div class="form-group col-sm-12 col-md-4">
					<label>Coupon Discount : </label>
					<span class="badge" :class="item.payment_status_class">
				    {{ item.discount_code }}
					</span>
				</div>
			</div>
		</card>

		<card>
			<template v-slot:header> Reservation Information </template>
			<br>
			<div class="table-responsive">
		    	<table class="table table-hover table-striped table-bordered text-center">
		    		<tr>
			    		<th>Scheduled Date</th>
			    		<th>Reservation Time</th>
			    		<th>Attendees</th>
			    		<th>Pastry</th>
			    		<th>Total Price</th>
			    		<th>Status</th>
			    		<th>Action</th>
		    		</tr>
		    		<tr v-for="data in item.items">
		    			<td>{{ data.scheduled_date }}</td>
		    			<td>{{ data.start_time }}</td>
		    			<td>{{ data.attendees }}</td>
		    			<td>{{ data.pastry }}</td>
		    			<td>{{ data.grand_total }}</td>
		    			<td>{{ data.claim_status }}</td>
		    			<td>
							<action-button
		                        v-if="!data.show_claim && !data.is_claimed && data.claim_status != 'Invoice not paid'"
		                        label="Mark as claimed"
		                        small 
		                        color="btn-warning"
		                        :show-alt="data.is_claim"
		                        :action-url="data.claimedUrl"
		                        confirm-dialog
		                        :disabled="loading"
		                        title="Mark As Claimed"
		                        :message="'Are you sure you want to mark this as claimed #' + data.id + '?'"
		                        @load="load"
		                        @success="sync"
		                        ></action-button>
		    			</td>
		    		</tr>
		    	</table>
		    </div>
		</card>
	</div>
	<!-- </form-request> -->
</template>

<script type="text/javascript">
import { EventBus }from '../../../EventBus.js';
import CrudMixin from 'Mixins/crud.js';

import ActionButton from 'Components/buttons/ActionButton.vue';
import Select from 'Components/inputs/Select.vue';
import ImagePicker from 'Components/inputs/ImagePicker.vue';
import TextEditor from 'Components/inputs/TextEditor.vue';
import Datepicker from 'Components/datepickers/Datepicker.vue';

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
		},

		sync() {
			this.fetch();
		},

		// load() {
		// 	this.fetch();
		// },
	},

	data() {
		return {
			item: [],
		}
	},

	


	components: {
		'action-button': ActionButton,
		'selector': Select,
		'image-picker': ImagePicker,
		'text-editor': TextEditor,
		'date-picker': Datepicker,
	},

	mixins: [ CrudMixin ],
}
</script>