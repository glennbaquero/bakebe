<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header> Branches </template>
			<br>

			<div class="row">

				<div class="form-group col-sm-12 col-md-4">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>

				<time-picker
				v-model="item.work_start"
				class="form-group col-sm-12 col-md-4 time"
				label="Operating Hours Start"
				name="work_start"
				placeholder="Choose time slot"
				></time-picker>

				<time-picker
				v-model="item.work_end"
				class="form-group col-sm-12 col-md-4 time"
				label="Operating Hours End"
				name="work_end"
				placeholder="Choose time slot"
				></time-picker>

				<div class="form-group col-sm-12 col-md-4">
					<label>Available Oven Open</label>
					<input v-model="item.available_oven" name="available_oven" type="number" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-4">
					<label>
						Location

						<position-finder v-if="item.location"
						:address="item.location"
						@onfetch="positionFetch"
						:fetchurl="fetchPositionUrl">
						</position-finder>
					</label>
					<input v-model="item.location" name="location" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-4">
					<label>Longitude</label>
					<input v-model="item.longitude" name="longitude" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-4">
					<label>Latitude</label>
					<input v-model="item.latitude" name="latitude" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-4">
					<label>Contact Number</label>
					<input v-model="item.contact_number" name="contact_number" type="number" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-4">
					<label>Contact Email</label>
					<input v-model="item.contact_email" name="contact_email" type="text" class="form-control">
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
                :message="'Are you sure you want to archive Experience #' + item.id + '?'"
                :alt-message="'Are you sure you want to restore Experience #' + item.id + '?'"
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
import CrudMixin from '../../../mixins/crud.js';

import ActionButton from 'Components/buttons/ActionButton.vue';
import Select from 'Components/inputs/Select.vue';
import ImagePicker from 'Components/inputs/ImagePicker.vue';
import TextEditor from 'Components/inputs/TextEditor.vue';
import TimePicker from 'Components/timepickers/Timepicker.vue';
import PositionFinder from 'Components/buttons/PositionFinder.vue';

export default {
	props: { 
		fetchPositionUrl: String
	},

	methods: {
		fetchSuccess(data) {
			this.item = data.item ? data.item : this.item;
		},

		positionFetch(position) {
		    alert(position.message);
		    this.item.latitude = position.latitude;
		    this.item.longitude = position.longitude;
		},

	},

	data() {
		return {
			item: {
				latitude: 0,
				longitude: 0,
			},
		}
	},

	components: {
		'action-button': ActionButton,
		'selector': Select,
		'image-picker': ImagePicker,
		'text-editor': TextEditor,
		'time-picker': TimePicker,
        'position-finder': PositionFinder,
	},

	mixins: [ CrudMixin ],
}
</script>