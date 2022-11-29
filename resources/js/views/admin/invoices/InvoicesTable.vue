<template>
    <div>
        <form-request :submit-url="exportUrl" @load="load" submit-on-success method="POST" :action="exportUrl">
            <div class="row">
                <selector
                class="mt-2 col-md-4"
                :items="branches"
                item-text="name"
                item-value="id"
                label="Filter by branch"
                @change="filter($event, 'branch_id')"
                placeholder="Filter by branch"
                name="branch_id"
                ></selector>

                <selector
                class="mt-2 col-md-4"
                :items="paymentTypes"
                item-text="label"
                item-value="value"
                label="Filter by payment type"
                @change="filter($event, 'payment_type')"
                placeholder="Filter by payment type"
                name="payment_type"
                ></selector>


                <selector
                class="mt-2 col-md-4"
                :items="paymentStatus"
                item-text="label"
                item-value="value"
                label="Filter by payment status"
                @change="filter($event, 'payment_status')"
                placeholder="Filter by payment status"
                name="payment_status"
                ></selector>
            </div>
            <filter-box @refresh="fetch">
                <template v-slot:left>
                    <date-range
                    class="mr-2"
                    @change="filter($event)"
                    ></date-range>
                    <action-button v-if="exportUrl" type="submit" :disabled="loading" class="btn-warning mr-2" icon="fa fa-download">Export</action-button>
                </template>
                <template v-slot:right>

                    <search-form
                    @search="filter($event, 'search')">
                    </search-form>

                </template>
            </filter-box>
        </form-request>

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
                    <td>{{ item.reference_number }}</td>
                    <td>{{ item.user }}</td>
                    <td>{{ item.booking_type }}</td>
                    <td>{{ item.pastry }}</td>
                    <td>{{ item.attendees }}</td>
                    <td>{{ item.scheduled_date }}</td>
                    <td>{{ item.start_time }}</td>
                    <td>{{ item.invoice_grand_total }}</td>
                    <td>
                        <span class="badge" :class="item.payment_type_class">
                            {{ item.payment_type_label }}
                        </span>
                    </td>     
                    <td>
                        <span class="badge" :class="item.payment_status_class">
                            {{ item.payment_status_label }}
                        </span>
                    </td>            
                    <td>{{ item.created_at }}</td>
                    <td>
                        <view-button :href="item.showUrl"></view-button>
                        
                        <action-button
                        v-if="!item.is_claimed && item.is_claimed != 'Invoice not paid'"
                        small 
                        color="btn-warning"
                        :action-url="item.markAsClaimed"
                        label="Mark as claimed"
                        confirm-dialog
                        :disabled="loading"
                        title="Mark As Claimed"
                        :message="'Are you sure you want to mark this as claimed ref# : ' + item.reference_number + '?'"
                        @load="load"
                        @success="sync"
                        ></action-button>
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
import Select from 'Components/inputs/Select.vue';
import DateRange from 'Components/datepickers/DateRange.vue';
import FormRequest from 'Components/forms/FormRequest.vue';

export default {
    computed: {
        headers() {
            let array = [
                { text: '#', value: 'id' },
                { text: 'Reference Number', value: 'reference_number' },
                { text: 'Customer', value: 'user' },
                { text: 'Booking Type', value: 'booking_type' },
                { text: 'Pastry', value: 'pastry' },
                { text: 'Attendees', value: 'attendees' },
                { text: 'Schedule date', value: 'schedule_date' },
                { text: 'Start Time', value: 'start_time' },
                { text: 'Total Payment', value: 'grand_total' },
                { text: 'Payment Type', value: 'payment_type' },
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

        paymentTypes: Array,
        paymentStatus: Array,
        exportUrl: String,
        branches: Array
    },

    mixins: [ ListMixin ],

    components: {
        'search-form': SearchForm,
        'view-button': ViewButton,
        'action-button': ActionButton,
        'selector': Select,
        'date-range': DateRange,
        'form-request': FormRequest,
    },
}
</script>