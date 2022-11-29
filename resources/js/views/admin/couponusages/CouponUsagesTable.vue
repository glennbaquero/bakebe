<template>
    <div>
        <filter-box @refresh="fetch">
            <template v-slot:left>
            </template>
            <template v-slot:right>

                <search-form
                @search="filter($event, 'search')">
                </search-form>

            </template>
        </filter-box>

        <!-- DATATABLE -->
        <data-table
        ref="data-table"
        :headers="headers"
        :filters="filters"
        :fetch-url="fetchUrl"
        :no-action="false"
        :disabled="disabled"
        order-by="id"
        @load="load"
        hide-actions
        >

            <template v-slot:body="{ items }">
                <tr v-for="item in items">
                    <td>{{ item.id }}</td>
                    <td>{{ item.fullname }}</td>
                    <td>{{ item.code }}</td>
                    <td>{{ item.reference_number }}</td>
                    <td>{{ item.total_payment }}</td>                    
                    <td>{{ item.discount }}</td> 
                    <td>{{ item.ovt }}</td> 
                    <td><view-button :href="item.showUrl"></view-button></td>                       
                </tr>
            </template>

        </data-table>
        <loader :loading="loading"></loader>
    </div>
</template>

<script type="text/javascript">
import ListMixin from 'Mixins/list.js';

import SearchForm from 'Components/forms/SearchForm.vue';
import ActionButton from 'Components/buttons/ActionButton.vue';
import ViewButton from 'Components/buttons/ViewButton.vue';

export default {
    computed: {
        headers() {
            let array = [
                { text: '#', value: 'id' },
                { text: 'FullName', value: 'fullname' },
                { text: 'Coupon Code', value: 'code' },                
                { text: 'Invoice Reference Number', value: 'reference_number' },
                { text: 'Total Invoice Payment', value: 'total_payment' },
                { text: 'Discount', value: 'discount' },
                { text: 'Overall Total Payment', value: 'ovt' },

            ];

            return array;
        },
    },

    props: {
        hideParent: {
            default: false,
            type: Boolean,
        },

        hideButtons: {
            default: false,
            type: Boolean,
        },
    },

    mixins: [ ListMixin ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
    },
}
</script>