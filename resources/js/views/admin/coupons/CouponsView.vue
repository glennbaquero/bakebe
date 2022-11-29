<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header> Coupons </template>
			<br>
			<div class="row">
				<div class="custom-control custom-switch ml-3">
					<input
					v-model="item.is_voucher"
					name="is_voucher" :checked="item.is_voucher" type="checkbox" class="custom-control-input" id="is_voucher">
					<label class="custom-control-label" for="is_voucher">Voucher from Metrodeal/Klook</label>
				</div>
			</div>
			<br>

			<div class="row">
				<selector class="col-sm-12 col-md-12"
				v-model="item.discount_type"
				name="discount_type"
				label="Discount Type"
				:items="types"
				item-value="value"
				item-text="label"
				empty-text="None"
				placeholder="Please select a Discount Type"
				></selector>

				<selector class="col-sm-12 col-md-12"
				v-if="isVoucher"
				v-model="item.voucher_type"
				name="voucher_type"
				label="Voucher Type"
				:items="voucher_types"
				item-value="value"
				item-text="label"
				empty-text="None"
				placeholder="Please select a Voucher Type"
				></selector>

				<div class="form-group col-sm-12 col-md-6">
					<label>Code</label>
					<input v-model="item.code" name="code" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Discount</label>
					<input v-model="item.discount" name="discount" type="number" step="0.01" class="form-control">
				</div>

				<selector class="col-sm-12 col-md-6"
				v-model="item.is_percentage"
				name="is_percentage"
				label="Discount Type"
				:items="discount_types"
				item-value="value"
				item-text="label"
				empty-text="None"
				placeholder="Please select a Ticket Category"
				></selector>

				<div class="form-group col-sm-12 col-md-6">
					<label>Required Invoice Total <small>(Required total of invoice price to avail set to zero(0) if not required)</small></label>
					<input v-model="item.required_invoice_total" name="required_invoice_total" type="number" step="0.01" class="form-control">
				</div>

				<selector class="col-sm-12 col-md-6"
				v-model="item.category_ids"
				name="category_ids[]"
				label="Ticket Category"
				:items="promos"
				item-value="id"
				item-text="name"
				empty-text="None"
				multiple
				placeholder="Please select a Ticket Category"
				></selector>

				<date-picker
				v-model="item.valid_start_at"
				class="form-group col-sm-12 col-md-6"
				label="Validity Start Date"
				name="valid_start_at"
				date-format="Y-m-d"
				placeholder="Choose dates"
				:enable-time="false"
				></date-picker>

				<date-picker
				v-model="item.valid_end_at"
				class="form-group col-sm-12 col-md-6"
				label="Validity End Date"
				name="valid_end_at"
				date-format="Y-m-d"
				placeholder="Choose dates"
				:enable-time="false"
				></date-picker>

				<date-picker
				v-model="item.usage_start_date_time"
				class="form-group col-sm-12 col-md-6"
				label="Usage Start Date and Time"
				name="usage_start_date_time"
				placeholder="Choose dates"
				></date-picker>

				<date-picker
				v-model="item.usage_end_date_time"
				class="form-group col-sm-12 col-md-6"
				label="Usage End Date and Time"
				name="usage_end_date_time"
				placeholder="Choose dates"
				></date-picker>

				<div class="form-group col-sm-12 col-md-6">
					<label>Max Usage</label>
					<input v-model="item.max_usage" name="max_usage" type="number" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Max User</label>
					<input v-model="item.max_user" name="max_user" type="number" class="form-control">
				</div>

			</div>

			<template v-slot:footer>            
                <action-button
                v-if="item.archiveUrl && item.restoreUrl"
                color="btn-danger"
                alt-color="btn-warning"
                :action-url="item.archiveUrl"
                :alt-action-url="item.restoreUrl"
                label="Archive"
                alt-label="Restore"
                :show-alt="item.deleted_at"
                confirm-dialog
                title="Archive Item"
                alt-title="Restore Item"
                :message="'Are you sure you want to archive Coupon ' + item.code + '?'"
                :alt-message="'Are you sure you want to restore Coupon ' + item.code + '?'"
                :disabled="loading"
                @load="load"
                @success="fetch"
                @error="fetch"
                ></action-button>
				<action-button type="submit" :disabled="loading" class="btn-primary">Save Changes</action-button>
			</template>
		</card>

		<loader :loading="loading"></loader>
		
	</form-request>
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
			this.types = data.types ? data.types : this.types;
			this.voucher_types = data.voucher_types ? data.voucher_types : this.voucher_types;
			this.promos = data.promos ? data.promos : this.promos;
		},

	},

	data() {
		return {
			item: [],
			types: [],
			voucher_types: [],
			promos: [],
			discount_types: [
				{
					value: 0,
					label: 'WHOLE AMOUNT (0.00)'
				},
				{
					value: 1,
					label: 'PERCENTAGE (%)'
				},
			]
		}
	},

	computed: {
		isVoucher() {
			var result = false;

			if(this.item.is_voucher) {
				result = true
			}

			return result;
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