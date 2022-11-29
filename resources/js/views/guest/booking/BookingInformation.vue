<template>
	<div class="frm-cntnr mt-5">
		<div class="w-85 ml-auto mr-0">
			<location-details v-if="step >= 2 && step <= 4" :payloads="payloads"></location-details>
			<booking-details v-if="step >= 3 && step <= 4" :payloads="payloads"></booking-details>
			<baking-schedule v-if="step >= 4 && step <= 4" :payloads="payloads"></baking-schedule>
		</div>

	</div>
</template>

<script>
import LocationDetails from './booking-details/LocationDetails.vue';
import BookingDetails from './booking-details/BookingDetails.vue';
import BakingSchedule from './booking-details/BakingSchedule.vue';

	export default {

		props: {
			payloads: Object,
			step: Number
		},

		components: {
			'location-details' : LocationDetails,
			'booking-details' : BookingDetails,
			'baking-schedule' : BakingSchedule,
		}
	}
</script>