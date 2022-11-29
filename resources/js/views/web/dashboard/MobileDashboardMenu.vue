<template>
	<div class="frm-cntnr bg-white mobile--dashMenu mobile-show">
		<div class="w-85 mx-auto">
			<select-field
			@change="selectorChanged"
			v-model="tab"
			:items="menus"
			item-value="value"
			item-text="menu"
			placeholder="Booking History"
			></select-field>
		</div>
	</div>
</template>

<script>
import Selector from '../../../components/inputs/Select.vue';
	
	export default {
		components: {
			'select-field' : Selector,
		},

		data: function() {
			return {
				tab: null,

				menus: [{ value: '/dashboard',
				     menu: 'Booking History',},

				{
					 value: '/edit-profile',
					 menu: 'Edit Profile',
				},
				{
					 value: '/change-password',
					 menu: 'Change Password',
				}
				]
			}
		},

		methods: {
			selectorChanged() {
				if(this.tab) {
					window.location.href = this.tab;
				}
			}
		}
	}
</script>