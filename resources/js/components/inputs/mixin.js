export default {
    mounted() {
        this.setupHint();
    },

    methods: {
        change() {
            this.$emit('change', this.input);
        },

        setupHint() {
            if (this.hint) {
                this.hintElem = $(this.$refs.hint);
                this.hintElem.tooltip({
                    placement: 'right',
                    title: this.hint,
                });
            }
        },

        keydown(event) {
            this.$emit('keydown', event);
        },

        keyup(event) {
            this.$emit('keyup', event);
        },
    },

    computed: {
        isInvalid() {
            return this.invalid;
        },

        invalidMessage() {
            return this.invalidText || this.error;
        },
    },

    watch: {
        error(value) {
            if (value) {
                this.invalid = true;
            } else {
                this.invalid = false;
            }
        },
    },

    props: {
        value: {},

        name: String,

        label: String,
        labelNote: [ String, Number ],
        labelNoteClass: {
            default: 'text-muted',
            type: String,
        },

        placeholder: String,
        emptyText: String,

        disabled: {
            default: false,
            type: Boolean,
        },

        error: String,

        hint: String,

        validatable: {
            default: true,
        },
    },

	data() {
        return {
            input: null,
            invalid: false,
            invalidText: null,

            hintElem: null,
        }
    },

    model: {
        prop: 'value',
        event: 'change',
    },
}