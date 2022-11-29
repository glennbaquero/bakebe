<template>
	<div>
		<booking-history v-if="!showSelectedBooking" :fetch-url="fetchUrl" @selectedBooking="selectedBooking(...arguments)">
		</booking-history>

		<selected-booking v-if="showSelectedBooking" :print-url="printUrl" :item="item" @backToHistory="showSelectedBooking = false">
		</selected-booking>
	</div>
</template>

<script>
import DashboardMenu from './DashboardMenu.vue';
import BookingHistory from './BookingHistory.vue';
import EditProfile from './EditProfile.vue';
import ChangePassword from './ChangePassword.vue';
import SelectedBookingHistory from './SelectedBookingHistory.vue';

	export default {
		props: {
			fetchUrl: String,
			
			printUrl: {
				type: String,
			}
		},

		components: {
			'dashboard-menu' : DashboardMenu,
			'booking-history' : BookingHistory,
			'edit-profile' : EditProfile, 
			'change-password' : ChangePassword,
			'selected-booking' : SelectedBookingHistory,
		},
		data() {
			return {
				item: {},
				showSelectedBooking: false
			}
		},

		methods: {
			selectedBooking(item) {
				this.item = item;
				this.showSelectedBooking = true;
				// console.log(item)
			}
		}
	}

</script>