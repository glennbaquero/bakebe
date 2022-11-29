<template>
  <form @submit.prevent="processForm">	
	<div class="frm-cntnr login--holder hdr--margin">
		<div class="w-100">
			<div class="row pt-6 mb-5">
				<div class="col-12 text-center">
					<h2 class="font-weight-bold">LOGIN</h2>
				</div>
			</div>

			<div class="row mb-3">
				<div class="col-12">
					<text-field
					id="email"
					v-model="email"
					label="Email Address"
					name="email"
					placeholder="Email Address"
					required
					></text-field>
				</div>
			</div>

			<div class="row mb-4">
				<div class="col-12">
						<div class="form-group">
							<label> Password</label>
							<div class="input-group">
								<input v-model="password" placeholder="Password" :type="hidden.password ? 'password' : 'text'" class="form-control">
								<div class="input-group-append">
					                <button type="button" @click="hidden.password = !hidden.password" class="btn btn-light border">
										<i v-if="hidden.password" class="fa fa-eye-slash"></i>
										<i v-if="!hidden.password" class="fa fa-eye"></i>
									</button>
					            </div>
							</div>
						</div>
				</div>
			</div>

			<div class="row mb-5">
				<div class="col-12 text-center">
					<a class="forgot--link text-muted" href="forgot-password">Forgot Password?</a>
				</div>
			</div>

			<div class="row mb-5">
				<div class="col-12 text-center">
					<button type="submit" class="btn btn-primary font-weight-bold text-white rounded-btn custom-btn">
						LOG IN
					</button>
				</div>
			</div>

			<div class="row text-center">
				<small class="mx-auto"><span>Not a customer yet? Sign up <a class="text-muted signup--link" href="register">here</a></span></small>
			</div>
		</div>
	</div>	
	<loading :active.sync="isLoading" 
	         :is-full-page="fullPage"
	         color="#e8627c"
	         ></loading>			

 </form>	
</template>
<script>
// import CrudMixin from '../../../mixins/crud.js';
// import ArrayHelpers from '../../../mixins/array.js';
import Loading from 'vue-loading-overlay';
import ErrorResponse from 'Mixins/errorResponse';
import 'vue-loading-overlay/dist/vue-loading.css'; 

import TextField from '../../../components/inputs/TextField.vue';
import PasswordField from '../../../components/inputs/Password.vue';

	export default {

	props: {
		submitUrl: String
	},

    data() { 
      return {
      	email: null,
		password: null,
		isLoading: false,
        fullPage: true,
	        hidden: {
	        	password: true,
	        }
        }
    },    


    methods: {

		processForm() {

			this.isLoading = true;
			
			var data = {
				email: this.email,	
				password: this.password,				
			}

			axios.post(this.submitUrl, data)		
				.then(response => 	{
					this.isLoading = false;
					swal.fire("Login: ", "Successfully!", "success")
					.then(response => {
						window.location.href = '/booking'
					});
				})
				.catch(errors => {
					this.isLoading = false;
					this.password = null;					
					var message = this.parseResponse(errors, 'error');
					swal.fire("Ooops", message , "error");

				})
		},
    },

	components: {
		'text-field' : TextField,
		'password-field' : PasswordField,
		 Loading
	},

    mixins: [ ErrorResponse ],

	}
</script>