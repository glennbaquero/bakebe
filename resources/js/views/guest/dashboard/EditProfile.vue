<template>
	<div class="frm-cntnr">
		<div class="w-90 mx-auto">
			<p class="font-weight-bold text-primary">EDIT PROFILE</p>

			<div class="w-100">
				<div class="w-30 text-center">
					<img class="mr-2 edit--img mx-auto mb-4" src="../../../../../public/images/assets/user1.png" alt="">
					<button class="btn btn-light-brown px-3 py-0 rounded-btn"><small class="text-white"><i class="fas fa-camera-retro"></i> Update Profile picture</small></button>	
				</div>
			</div>
			
			<div class="w-60">
				<div class="row mt-5">
					<div class="col-6">
						<text-field
						label="First Name"
						>
						</text-field>
					</div>

					<div class="col-6">
						<text-field
						label="Last Name"
						>
						</text-field>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<text-field
						label="Email"
						readonly
						disabled
						>
						</text-field>
					</div>
				</div>

				<div class="row mb-3">
					<div class="col-12">
						<number-field
						label="Mobile Number"
						>
						</number-field>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<button class="btn btn-primary rounded-btn font-weight-bold">SAVE & UPDATE</button>
					</div>
				</div>	
			</div>
			
		</div>
	</div>	
</template>
<script>
import TextField from '../../../components/inputs/TextField.vue';
import NumberField from '../../../components/inputs/NumberField.vue';

	export default {
		components: {
			'text-field' : TextField,
			'number-field' : NumberField,
		}
	}
</script>