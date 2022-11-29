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
                    <td>{{ item.name }}</td>
                    <td>{{ item.date }}</td>
                    <td>{{ item.time }}</td>
                    <td>
                        <span class="badge" :class="item.whole_day_class" v-html="item.whole_day_label"></span>
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
                        :message="'Are you sure you want to archive Block Date/Time #' + item.id + '?'"
                        :alt-message="'Are you sure you want to restore Block Date/Time #' + item.id + '?'"
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
                { text: 'Reason', value: 'name' },
                { text: 'Date', value: 'date' },
                { text: 'Time', value: 'time' },
                { text: 'Whole Day', value: 'is_whole_day' },
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