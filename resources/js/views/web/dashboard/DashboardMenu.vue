<template>
	<div class="frm-cntnr bg-white">
		<div class="w-80 mx-auto mb-5">
			<div class="inlineBlock-parent">
				<img class="profile--img mr-2" src="../../../../../public/images/avatar.png" alt="">
				<!-- <div class="profile--img" style="background-image: url('images/assets/calendar.png')"></div> -->
				<p class="font-weight-bold mb-0">{{ item.firstname }}</p>
			</div>
		</div>

		<div class="w-80 mx-auto dash--menu">
			<ul class="pl-0">
				<li class="mb-2"><small><a class="active" href="#">Booking History</a></small></li>
				<li class="mb-2"><small><a href="#">Edit Profile</a></small></li>
				<li class="mb-2"><small><a href="#">Change Password</a></small></li>
			</ul>
			<div class="menu--space w-100"></div>
			
			<p class="font-weight-bold mb-0 pb-4"><a class="text-muted" href="logout">Logout</a></p>
		</div>
	</div>
</template>
<script>
import CrudMixin from '../../../mixins/crud.js';
import ArrayHelpers from '../../../mixins/array.js';
export default {

	methods: {

		fetchSuccess(data) {	
			this.item = data.item ? data.item : this.item;
		}
	},

	    data() { 
	      return {
			item: {},      	

	        }
	   },

	  mixins: [ CrudMixin, ArrayHelpers ]

}
</script>