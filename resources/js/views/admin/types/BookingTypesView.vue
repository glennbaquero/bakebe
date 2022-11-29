<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header> Booking Type </template>
			<br>
			<div class="row">

				<div class="form-group col-sm-12 col-md-6">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Expected Duration</label>
					<input v-model="item.expected_duration" name="expected_duration" type="text" step="0.01" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Rate</label>
					<input v-model="item.rate" name="rate" type="number" step="0.01" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6">
					<label>Additional Fee</label>
					<input v-model="item.additional_fee" name="additional_fee" type="number" step="0.01" class="form-control">
				</div>

			</div>
			<div class="row">
				<text-editor
				v-model="item.description"
				class="col-md-12"
				label="Description"
				name="description"
				row="5"
				></text-editor>
			</div>
			<div class="row">
				<image-picker
				:value="item.path"
				class="form-group col-md-12 col-md-12 mt-2"
                label="Image"
                name="image_path"
                placeholder="Choose a File"
				></image-picker>
			</div>

			<template v-slot:footer>
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
			this.categories = data.categories ? data.categories : this.categories;
		},

	},

	data() {
		return {
			item: [],
			categories: [],
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