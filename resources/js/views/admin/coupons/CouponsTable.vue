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
        :no-action="noAction"
        :disabled="disabled"
        order-by="id"
        @load="load"
        >

            <template v-slot:body="{ items }">
                <tr v-for="item in items">
                    <td>{{ item.id }}</td>
                    <td>{{ item.code }}</td>
                    <td>{{ item.name }}</td>
                    <td>{{ item.discount }}</td>
                    <td>
                        <span class="badge" :class="item.type_class">
                            {{ item.type_label }}
                        </span>
                    </td>
                    <td>{{ item.max_usage }}</td>                    
                    <td>{{ item.max_user }}</td>
                    <td>{{ item.valid_start_at }}</td>
                    <td>{{ item.valid_end_at }}</td>
                    <td>
                        <span class="badge" :class="item.status_class">
                            {{ item.status_label }}
                        </span>
                    </td>
                    <td>{{ item.created_at }}</td>
                    <td>                        
                        <action-button
                        v-if="!hideButtons"
                        small 
                        color="btn-danger"
                        alt-color="btn-warning"
                        :show-alt="item.deleted_at"
                        :action-url="item.archiveUrl"
                        :alt-action-url="item.restoreUrl"
                        icon="fas fa-trash"
                        alt-icon="fas fa-trash-restore-alt"
                        confirm-dialog
                        :disabled="loading"
                        title="Archive Item"
                        alt-title="Restore Item"
                        :message="'Are you sure you want to archive Trail #' + item.id + '?'"
                        :alt-message="'Are you sure you want to restore Trail #' + item.id + '?'"
                        @load="load"
                        @success="sync"
                        ></action-button>
                        <view-button :href="item.showUrl"></view-button>
                    </td>
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
                { text: 'Code', value: 'code' },
                { text: 'Name', value: 'name' },
                { text: 'Discount', value: 'discount' },
                { text: 'Type', value: 'discount_type' },
                { text: 'Max Usage', value: 'max_usage' },
                { text: 'Max User', value: 'max_user' },
                { text: 'Valid Start Date', value: 'valid_start_at' },
                { text: 'Valid End Date', value: 'valid_end_at' },
                { text: 'Status', value: 'status' },
            ];


            array = array.concat([
                { text: 'Created Date', value: 'created_at' },
            ]);

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