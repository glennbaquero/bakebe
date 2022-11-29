<template>
	<div >
	
		<card>
			<template v-slot:header>Coupon Usage Information</template>

			<div class="row">
				<div class="form-group col-sm-12 col-md-6">
					<label>FullName</label>
					<input v-model="item.fullname" name="fullname" type="text" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Code</label>
					<input v-model="item.code" name="code" type="text" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Reference Number</label>
					<input v-model="item.reference_number" name="reference_number" type="text" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Total Payment</label>
					<input v-model="item.total_payment" name="total_payment" type="text" class="form-control">
				</div>
				<div class="form-group col-sm-12 col-md-6">
					<label>Overall Total</label>
					<input v-model="item.ovt" name="ovt" type="text" class="form-control">
				</div>				

			</div>
			
			<div class="row">

				<text-editor
				v-model="item.concerns"
				class="col-sm-12"
				label="Special Request or Concerns(optional)"
				name="concerns"
				row="5"
				></text-editor>
	
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
                :message="'Are you sure you want to archive Inquiry #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Inquiry #' + item.id + '?'"
                :disabled="loading"
                @load="load"
                @success="fetch"
                @error="fetch"
                ></action-button>
			</template>
		</card>

		<loader :loading="loading"></loader>
		
	</div>
</template>

<script type="text/javascript">
import { EventBus }from '../../../EventBus.js';
import CrudMixin from '../../../mixins/crud.js';

import ActionButton from '../../../components/buttons/ActionButton.vue';
import Select from '../../../components/inputs/Select.vue';
import ImagePicker from '../../../components/inputs/ImagePicker.vue';
import TextEditor from '../../../components/inputs/TextEditor.vue';
import Datepicker from '../../../components/datepickers/Datepicker.vue';
import TimePicker from '../../../components/timepickers/Timepicker.vue';

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
		},
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
		'time-picker': TimePicker,
	},

	mixins: [ CrudMixin ],
}
</script>