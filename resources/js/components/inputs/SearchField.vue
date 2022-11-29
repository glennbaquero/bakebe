<template>
    <div class="form-group">
        <form @submit.prevent="search" method="GET" action="#">
            <div class="input-group">
                <input :placeholder="placeholder" v-model="value" :name="name" :type="type" class="form-control">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-light border">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script type="text/javascript">
export default {
    data() {
        return {
            value: null
        };
    },

    props: {
        name: String,
        label: String,
        placeholder: String,
        type: {
            default: 'text',
            type: String,
        },
    },

    methods: {
        search() {
            this.$emit('search', this.value);
        }
    },
}
</script>