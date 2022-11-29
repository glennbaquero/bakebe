<template>
	<div class="frm-cntnr">
		<div class="w-90 mx-auto">
			<p class="mb-3 font-weight-bold text-primary">CHANGE PASSWORD</p>
			<p>Leave the fields empty if you wish to reatain your password</p>

			<div class="w-60">
				<div class="row">
					<div class="col-12">
						<password-field
						label="Current Password"
						>
						</password-field>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-sm-12 col-12">
						<password-field
						label="New Password"
						>
						</password-field>
					</div>
					<div class="col-md-6 col-sm-12 col-12">
						<password-field
						label="Confirm New Password"
						>
						</password-field>
					</div>
				</div>

				<div class="row mt-5">
					<div class="col-12">
						<button class="btn btn-primary rounded-btn font-weight-bold">SAVE & UPDATE</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
import PasswordField from '../../../components/inputs/Password.vue';

	export default {
		components: {
			'password-field' : PasswordField,
		}
	}

</script>