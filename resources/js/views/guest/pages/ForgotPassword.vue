<template>
	<div>
		<div class="frm-cntnr login--holder hdr--margin">
			<div class="w-100">
				<div class="row pt-6 mb-5">
					<div class="col-12 text-center">
						<h2 class="font-weight-bold">FORGOT PASSWORD</h2>
					</div>
				</div>

				<div class="row mb-3">
					<div class="col-12">
						<text-field
						v-model="email"
						label="Email Address"
						></text-field>
					</div>
				</div>

				<div class="row mb-5">
					<div class="col-12 text-center">
						<button class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn" @click="sendRequest()">
							SEND RESET LINK
						</button>
					</div>
				</div>

				<div class="row text-center">
					<small class="mx-auto"><span>Returning customer? Sign in <a class="text-muted signup--link" href="#">here</a></span></small>
				</div>
			</div>
		</div>
		<loading 
			:active.sync="isLoading" 
	        :is-full-page="true"
	        color="#e8627c"
		></loading>
	</div>
</template>
<script>
import TextField from 'Components/inputs/TextField.vue';
import PasswordField from 'Components/inputs/Password.vue';
import Loading from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/vue-loading.css';
import ErrorResponseMixins from 'Mixins/errorResponse.js';

	export default {
		props: {
			requestUrl: String
		},

		data() {
			return {
				email: null,
				isLoading: false
			}
		},

		components: {
			'text-field' : TextField,
			'password-field' : PasswordField,
			Loading
		},

		mixins: [ ErrorResponseMixins ],

		methods: {
			sendRequest() {
				this.isLoading = true;
				var data = {
					email: this.email
				};

				axios.post(this.requestUrl, data)
					.then(response => {
						this.isLoading = false;
						swal.fire(
						      'Hoooray!',
						      'We sent the link to your email, kindly check look at email provided.',
						      'success'
						    );
					})
					.catch(errors => {
						this.isLoading = false;
						swal.fire(
						      'Ooops!',
						      this.parseError(errors),
						      'error'
						    );	
					})
			}
		}
	}
</script>