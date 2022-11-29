<template>
	<div class="form-group">
		<label v-if="label || labelNote">{{ label }} <small v-if="labelNote" :class="labelNoteClass">{{ labelNote }}</small></label>
		
		<div :class="{ 'input-group': $slots['append'] || $slots['prepend'] }">
			<div v-if="$slots['prepend']" class="input-group-prepend">
				<slot name="prepend"></slot>
			</div>

			<input 
			v-model="input" 
			@input="change" 
			@keydown="keydown" 
			@keyup="keyup" 
			@keypress="validate" 
			@paste="validate" 
			@blur="validateFormat" 
			:type="type" 
			:name="name" 
			class="form-control" 
			:class="{ 'is-invalid' : isInvalid }"
			:placeholder="placeholder" 
			:disabled="disabled">

			<div v-if="$slots['append']" class="input-group-append">
				<slot name="append"></slot>
			</div>
		</div>

		<span v-if="isInvalid" class="invalid-feedback d-block">{{ invalidMessage }}</span>
	</div>
</template>

<script>
import InputMixin from './mixin.js';

export default {
	mounted() {
		this.setup(this.type);
		this.input = this.value;
	},

	methods: {
		setup(type) {
			switch(type) {
				case 'number':
						this.pattern = /^[0-9]*\.?[0-9]*$/;
						this.format = /^\d*\.?\d*$/;
					break;
				case 'integer':
						this.pattern = /^[0-9]+$/;
						this.format = /^[0-9]+$/;
					break;
				case 'real-integer':
						this.pattern = /^[0-9-]*$/;
						this.format = /^[-]?[0-9]+$/;
					break;
			}
		},

		validate(event) {
			let key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
			let ENTER = event.keyCode == 13;

			if (!this.pattern.test(key) && !ENTER) {
				event.preventDefault();
			}
		},

		validateFormat(event) {
			if (this.input && !this.format.test(this.input)) {
				switch(this.type) {
					case 'number':
							this.input = parseFloat(this.input);
							this.change();
						break;
					case 'real-integer':
							this.input = parseInt(this.input);
							this.change();
						break;
				}
			}
		},

		change() {
			this.$emit('change', this.input);
		}
	},

	watch: {
		value(value) {
			this.input = value;
		},
	},

	data: () => ({
		pattern: /^[0-9]*\.?[0-9]*$/,
		format: /^\d*\.?\d*$/,
	}),

	props: {
		type: {
			default: 'number',
			type: String,
		},
	},

    mixins: [ InputMixin ],
}
</script>