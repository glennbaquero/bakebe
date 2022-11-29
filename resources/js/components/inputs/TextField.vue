<template>
	<div class="form-group">
		<label class="theme--text" v-if="label">
            {{ label }} 
            <small class="theme--text" v-if="labelNote" :class="labelNoteClass">{{ labelNote }}</small> 
            <small v-if="hint" ref="hint" class="fas fa-question-circle ml-1"></small>
        </label>
        
        <div :class="{ 'input-group': $slots['append'] || $slots['prepend'] }">
            <div v-if="$slots['prepend']" class="input-group-prepend">
                <slot name="prepend"></slot>
            </div>

            <input v-model="input" 
            :type="type" 
            @input="change" 
            @keydown="keydown" 
            :name="name" 
            :placeholder="placeholder" 
            :maxlength="maxCounter" 
            class="form-control" 
            :class="{ 'is-invalid' : isInvalid }" 
            :disabled="disabled">

            <div v-if="$slots['append']" class="input-group-append">
                <slot name="append"></slot>
            </div>
        </div>
        
        <small v-if="!isInvalid && maxCounter" class="text-counter text-muted">{{ textLength }} of {{ maxCounter }} characters used</small>
		
        <span v-if="isInvalid" class="invalid-feedback d-block">{{ invalidMessage }}</span>
	</div>
</template>

<script>
import InputMixin from './mixin.js';

export default {
	mounted() {
        this.input = this.value;
    },

    methods: {
    	change() {
            if (this.invalid) {
                this.invalid = false;
            }
            
    		this.$emit('change', this.input);
    	},
    },

    watch: {
    	value(value) {
    		this.input = value;
    	}
    },

    computed: {
        textLength() {
            return this.input ? this.input.length : 0;
        },
    },

    props: {
        type: {
            default: 'text',
            type: String,
        },

        maxCounter: {},
    },

	mixins: [ InputMixin ],
}
</script>

<style scoped>
.is-invalid .text-counter {
    display: none;
}
</style>