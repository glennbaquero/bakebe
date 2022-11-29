<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header> Promos </template>
			<br>

			<div class="row">
				<div class="custom-control custom-switch ml-3">
					<input
					v-model="item.is_active"
					name="is_active" :checked="item.is_active" type="checkbox" class="custom-control-input" id="is_active">
					<label class="custom-control-label" for="is_active">Active</label>
				</div>
			</div>

			<div class="row">

				<selector class="col-sm-12 col-md-6"
				v-model="item.promo_category_id"
				name="promo_category_id"
				label="Category"
				:items="categories"
				item-value="id"
				item-text="name"
				empty-text="None"
				placeholder="Please select a Category"
				></selector>

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
				:items="types"
				item-value="value"
				item-text="label"
				empty-text="None"
				placeholder="Please select a Discount Type"
				></selector>

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
                :message="'Are you sure you want to archive Promo ' + item.name + '?'"
                :alt-message="'Are you sure you want to restore Promo ' + item.name + '?'"
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
			this.categories = data.categories ? data.categories : this.categories;
			this.types = data.types ? data.types : this.types;
		},

	},

	data() {
		return {
			item: [],
			categories: [],
			types: [],
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