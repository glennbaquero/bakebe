<template>
	<!-- <div class="dashboard--holder frm-cntnr">
		<div class="w-100 inlineBlock-parent">
			<div class="w-30 align-t">
				<div class="w-90 dash--menuHolder bg-white py-4 shadow">
					<dashboard-menu>

					</dashboard-menu>
				</div>
			</div
			><div class="w-70 align-t">
				<div class="w-95 mx-auto dash--content bg-white py-4 shadow"> -->
					<div>
						<booking-history :fetch-url="fetchUrl" @selectedBooking="selectedBooking(...arguments)">

						</booking-history>
						
						<selected-booking v-if="showSelectedBooking" :item="item">
						
						</selected-booking>
					</div>

				<!-- </div>
			</div>
		</div>
	</div> -->
</template>

<script>
import DashboardMenu from './DashboardMenu.vue';
import BookingHistory from './BookingHistory.vue';
import EditProfile from './EditProfile.vue';
import ChangePassword from './ChangePassword.vue';
import SelectedBookingHistory from './SelectedBookingHistory.vue';

	export default {
		props: {
			fetchUrl: String
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
				console.log(item)
			}
		}
	}

</script>