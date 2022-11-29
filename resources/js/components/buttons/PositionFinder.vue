<template>
	<a @click.prevent="fetch" href="#" class="btn btn-xs btn-warning"><i class="fas fa-map-pin"></i> Get Latitude & Longitude</a>
</template>

<script>
export default {
	props: {
		fetchurl: {},
		address: {}
	},

	data() {
		return {

		};
	},

	methods: {
		fetch() {
			axios.post(this.fetchurl, {
				address: this.address,
			}).then(response => {
				const data = response.data;

				this.$emit('onfetch', data);
			}).catch(error => {
				this.showErrors(error);
			});
		}
	},
}
</script>