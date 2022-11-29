<template>
	<form-request :submit-url="submitUrl" @load="load" @success="fetch" confirm-dialog sync-on-success>
	
		<card>
			<template v-slot:header> Pastry </template>
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
				<div class="custom-control custom-switch ml-3">
					<input
					v-model="item.is_available_express"
					name="is_available_express" :checked="item.is_available_express" type="checkbox" class="custom-control-input" id="is_available_express" @change="show('express')">
					<label class="custom-control-label" for="is_available_express">Available for Express</label>
				</div>
			</div>
			<div class="row">
				<div class="custom-control custom-switch ml-3">
					<input
					v-model="item.is_available_regular"
					name="is_available_regular" :checked="item.is_available_regular" type="checkbox" class="custom-control-input" id="is_available_regular" @change="show('regular')">
					<label class="custom-control-label" for="is_available_regular">Available for Regular</label>
				</div>
			</div>

			<div class="row">

				<selector class="col-sm-12 col-md-4"
				v-model="item.category_id"
				name="category_id"
				label="Category"
				:items="categories"
				item-value="id"
				item-text="name"
				empty-text="None"
				placeholder="Please select a Category"
				></selector>

				<div class="form-group col-sm-12 col-md-4">
					<label>Name</label>
					<input v-model="item.name" name="name" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-4">
					<label>Difficulty</label>
					<input v-model="item.difficulty" name="difficulty" type="text" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6" v-if="showRegularField">
					<label>Regular Duration <small>(per minutes)</small></label>
					<input v-model="item.duration" name="duration" type="number" min="1" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6" v-if="showExpressField">
					<label>Express Duration<small>(per minutes)</small></label>
					<input v-model="item.express_duration" name="express_duration" type="number" min="1" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6" v-if="showRegularField">
					<label>Regular Amount</label>
					<input v-model="item.regular_amount" name="regular_amount" type="number" min="1" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6" v-if="showExpressField">
					<label>Express Amount</label>
					<input v-model="item.express_amount" name="express_amount" type="number" min="1" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6" v-if="showRegularField">
					<label>Additional Fee for Regular Amount</label>
					<input v-model="item.additional_regular_amount" name="additional_regular_amount" type="number" min="1" class="form-control">
				</div>

				<div class="form-group col-sm-12 col-md-6" v-if="showExpressField">
					<label>Additional Fee for Express Amount</label>
					<input v-model="item.additional_express_amount" name="additional_express_amount" type="number" min="1" class="form-control">
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
			this.showExpressField = data.item ? data.item.is_available_express : this.showExpressField;
			this.showRegularField = data.item ? data.item.is_available_regular : this.showRegularField;
		},

		show(type) {
			switch(type) {
				case 'express' :
					this.showExpressField = !this.showExpressField;
					break;
				case 'regular' :
					this.showRegularField = !this.showRegularField;
					break;
			}
		}

	},

	watch: {
		showExpressField(val) {
			if(!val) {
				this.item.is_available_regular = true;
				this.showRegularField = true;
			}
		},

		showRegularField(val) {
			if(!val) {
				this.item.is_available_express = true;
				this.showExpressField = true;
			}
		},
	},

	data() {
		return {
			item: [],
			categories: [],
			showRegularField: true,
			showExpressField: true,
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