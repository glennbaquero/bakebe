<template>
	<div class="row">
		<div class="col-12 mb-2 px-0">
			<small class="">Type of Booking</small>	
		</div>
		<div class="col-12 mb-3 px-0">
			<small class="font-weight-bold text-pink">{{ payloads.selectedType.name }}</small>	
		</div>

		<div class="divider w-100 mb-3"></div>
	</div>
</template>
<script>
	export default{
		props: {
			payloads: Object
		}
	}
</script>