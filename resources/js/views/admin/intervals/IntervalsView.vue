<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header> Block Date or Time Interval </template>
			<br>

			<div class="row">
				<div class="custom-control custom-switch ml-3">
					<input
					v-model="item.is_whole_day"
					name="is_whole_day" :checked="item.is_whole_day" type="checkbox" class="custom-control-input" id="is_whole_day">
					<label class="custom-control-label" for="is_whole_day">Whole Day</label>
				</div>
			</div>

			<div class="row">
				<selector class="col-sm-12 col-md-4"
				v-model="item.branch_ids"
				name="branches_id[]"
				label="Branch"
				:multiple="true"
				:items="branches"
				item-value="id"
				item-text="name"
				empty-text="None"
				placeholder="Please select branch"
				></selector>

				<div class="form-group col-sm-12 col-md-4">
					<label>Reason</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>

				<date-picker
				v-model="item.date"
				class="form-group col-sm-12 col-md-4"
				label="Date"
				name="date"
				date-format="Y-m-d"
				placeholder="Choose date"
				:enable-time="false"
				></date-picker>

			</div>
			<div class="row">
				
				<time-picker
				v-if="!item.is_whole_day"
				v-model="item.start_time"
				class="form-group col-sm-12 col-md-6 time"
				label="Block Start From"
				name="start_time"
				placeholder="Choose time slot"
				></time-picker>

				<time-picker
				v-if="!item.is_whole_day"
				v-model="item.end_time"
				class="form-group col-sm-12 col-md-6 time"
				label="Block Start To"
				name="end_time"
				placeholder="Choose time slot"
				></time-picker>
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
                :message="'Are you sure you want to archive Block Date/Time Interval #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Block Date/Time Interval #' + item.id + '?'"
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
import TimePicker from 'Components/timepickers/Timepicker.vue';

export default {
	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
			this.branches = data.branches ? data.branches : this.branches;
		},

	},

	data() {
		return {
			item: [],
			branches: [],
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