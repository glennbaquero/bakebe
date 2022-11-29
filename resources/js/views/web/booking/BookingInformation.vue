<template>
	<div class="frm-cntnr mt-5">
		<div class="w-70 ml-auto mr-0">
			<location-details></location-details>
			<booking-details></booking-details>
			<baking-schedule></baking-schedule>
		</div>

	</div>
</template>

<script>
import LocationDetails from './booking-details/LocationDetails.vue';
import BookingDetails from './booking-details/BookingDetails.vue';
import BakingSchedule from './booking-details/BakingSchedule.vue';

	export default {

		components: {
			'location-details' : LocationDetails,
			'booking-details' : BookingDetails,
			'baking-schedule' : BakingSchedule,
		}
	}
</script>