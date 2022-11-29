<template>
	<div class="frm-cntnr mt-5">
		<div class="w-100">
			<p class="frm-title text-secondary mb-3">CHOOSE LOCATION</p>

			<p class="mb-5">Choose where you want  to book your appointment</p>

			<select-field
			:items="branches"
			item-value="id"
			item-text="branch"
			placeholder="Choose Location"
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

		data: function () {
			return {

				branches: [{ id: '1',
						     branch: 'Branch 1'},

						{
							 id: '2',
							 branch: 'Branch 2'	
						}]
			}
		}
	}
</script>