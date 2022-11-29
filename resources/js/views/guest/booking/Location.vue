<template>
	<div class="frm-cntnr mt-5">
		<div class="w-100">
			<p class="frm-title text-secondary mb-3">CHOOSE LOCATION</p>

			<p class="mb-5">Choose where you want  to book your appointment</p>

			<select-field
			:items="branches"
			@change="branchChanged()"
			v-model="payloads.branchId"
			item-value="id"
			item-text="name"
			placeholder="Choose Location"
			></select-field>
		</div>
	</div>
</template>

<script>
import Selector from 'Components/inputs/Select.vue';
	
	export default {
		props: {
			branches: Array,
			payloads: Object
		},

		components: {
			'select-field' : Selector,
		},

		methods: {
			branchChanged() {
				var id = parseInt(this.payloads.branchId);

				_.each(this.branches, (branch) => {
					if(branch.id === id) {
						this.payloads.branchSelected = branch;
					}
				})

				axios.post(this.$parent.branchBlockUrl, { branch_id: id })
					.then(response => {
						this.$parent.blocklists = response.data.blocklists;
					})
			}
		}
	}
</script>