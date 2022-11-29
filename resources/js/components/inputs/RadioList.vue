<template>
    <div class="form-group">
        <label v-if="label">
            {{ label }} 
            <small v-if="labelNote" :class="labelNoteClass">{{ labelNote }}</small> 
            <small v-if="hint" ref="hint" class="fas fa-question-circle ml-1"></small>
        </label>
        <div v-for="(item, index) in items" class="custom-control custom-radio" :class="{ 'custom-control-inline': inline }">
            <input v-model="input" @change="change" :value="item[itemValue]" type="radio" :id="id + '-' + index" :name="name" class="custom-control-input">
            <label class="custom-control-label theme--text" :for="id + '-' + index">
                <slot :item="item">{{ item[itemText] }}</slot>         
            </label>
        </div>  
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
            this.$emit('change', this.input);
        }
    },

    data: () => ({
        input: null,
    }),

    watch: {
        value(value) {
            this.input = value;
        }
    },

    computed: {
        id() {
            return 'radio-list-' + this._uid;
        },
    },

    props: {
        items: {},

        name: String,

        itemText: {
            default: 'label',
            type: String,
        },

        itemValue: {
            default: 'value',
            type: String,
        },

        inline: {
            default: false,
            type: Boolean,
        },
    },

    mixins: [ InputMixin ],
}
</script>