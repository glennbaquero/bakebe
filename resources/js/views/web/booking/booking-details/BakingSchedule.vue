<template>
	<div class="row">
		<div class="col-12 mb-3 px-0">
			<small class="">Baking Schedule</small>	
		</div>
		<div v-for="schedule in schedules" class="col-12 mb-3 px-0 baking--holder">
			<small class="mb-2"><span><img class="img-contain mr-2" src="images/assets/product1.png" alt=""> Earl Grey Chiffon Sandwiches</span></small>	
		</div>

		<div class="divider w-100 mb-3"></div>
	</div>
</template>

<script>
	
	export default {

		data: function () {
			return {
				schedules: 3,	
			}
		}
	}
</script>