<template>
  <!-- <form @submit.prevent="processForm">	 -->
	<div class="frm-cntnr login--holder pb-3 hdr--margin">
		<div class="w-100">
			<div class="row pt-6 mb-5">
				<div class="col-12 text-center">
					<h2 class="font-weight-bold">SIGNUP</h2>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-md-6 col-sm-12 col-12">
					<text-field
					id = "first_name"
					v-model="first_name"
					name="first_name"
					label="First Name"
					required					
					></text-field>
				</div>
				<div class="col-md-6 sol-sm-12 col-12">
					<text-field
					id = "last_name"
					v-model="last_name"
					name="last_name"
					label="Last Name"
					required
					></text-field>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-12">
					<text-field
					id = "email"
					v-model="email"
					name = "email"
					label="Email Address"
					required
					></text-field>
				</div>
			</div>

			<div class="row mb-2">
				<div class="col-12">
					<contact-number
					id="mobile_number"
					v-model="mobile_number"
					name="mobile_number"
					label="Mobile Number"
					required
					></contact-number>
				</div>
			</div>

			<div class="row mb-4">
					<div class="col-md-6 col-sm-12 col-12">
						<div class="form-group">
							<label>New Password</label>
							<div class="input-group">
								<input v-model="password" placeholder="New Password" :type="hidden.password ? 'password' : 'text'" class="form-control">
								<div class="input-group-append">
					                <button type="button" @click="hidden.password = !hidden.password" class="btn btn-light border">
										<i v-if="hidden.password" class="fa fa-eye-slash"></i>
										<i v-if="!hidden.password" class="fa fa-eye"></i>
									</button>
					            </div>
							</div>
						</div>
					</div>
					<div class="col-md-6 col-sm-12 col-12">
						<div class="form-group">
							<label>Confirm New Password</label>
							<div class="input-group">
								<input v-model="password_confirmation" placeholder="Confirm New Password" :type="hidden.password_confirmation ? 'password' : 'text'" class="form-control">
								<div class="input-group-append">
					                <button type="button" @click="hidden.password_confirmation = !hidden.password_confirmation" class="btn btn-light border">
										<i v-if="hidden.password_confirmation" class="fa fa-eye-slash"></i>
										<i v-if="!hidden.password_confirmation" class="fa fa-eye"></i>
									</button>
					            </div>
							</div>
						</div>
					</div>
			</div>

<!-- 			<div class="row mb-5">
				<div class="col-12">
					<p class="text-muted"><span class="checkbox--holder"><input type="checkbox" checked="checked" class="mr-4"><span class="checkbox"></span>By ticking this box, you agree to our <a class="text-pink" data-toggle="modal" data-target="#termsModal">Terms of Conditions</a> and that you have read our <a class="text-pink" href="#">Privacy Policy</a></span></p>
				</div>
			</div> -->

			<div class="row mb-5">
				<div class="col-12 text-center">
					<button type="submit" class="btn btn-primary rounded-btn font-weight-bold" data-toggle="modal" data-target="#termsModal">SIGN UP</button>
				</div>
			</div>

			<div class="row text-center">
				<small class="mx-auto text-muted"><span>Returning customer? Sign in <a class="text-muted signup--link" href="login">here</a></span></small>
			</div>
			<terms-modal @accceptAndContinue="processForm"></terms-modal>
			<loading :active.sync="isLoading" 
			         :is-full-page="fullPage"
			         color="#e8627c"
			         ></loading>			
		</div>
	</div>
  <!-- </form> -->
</template>
<script>
import CrudMixin from '../../../mixins/crud.js';
import ArrayHelpers from '../../../mixins/array.js';
import ActionButton from '../../../components/buttons/ActionButton.vue';
import Loading from 'vue-loading-overlay';
import ErrorResponse from 'Mixins/errorResponse';
import 'vue-loading-overlay/dist/vue-loading.css'; 

import TextField from '../../../components/inputs/TextField.vue';
import PasswordField from '../../../components/inputs/Password.vue';
import ContactNumber from '../../../components/inputs/ContactNumber.vue';
import TermsModal from '../modals/TermsModal.vue';

	export default {
		props: {
			termsConditionText: String
		},

	    data() { 
	      return {
			first_name: null,
			last_name: null,
			email: null,						
			mobile_number: null,
			password: null,
			password_confirmation: null,      	
			isLoading: false,
	        fullPage: true,
		        hidden: {
		        	password: true,
		        	password_confirmation: true,
		        }
	        }
	    },    


	    methods: {
	        fetchSuccess(data) {
	            this.item = data.item ? data.item : this.item;
	        },

			processForm() {

				this.isLoading = true;
				
				var data = {
					first_name: this.first_name,	
					last_name: this.last_name,				
					email: this.email,
					mobile_number: this.mobile_number,	
					password: this.password,				
					password_confirmation: this.password_confirmation,
				}

				axios.post(this.submitUrl, data)		
					.then(response => {
						this.isLoading = false;
						this.first_name = null;
						this.last_name = null;
						this.email = null;					
						this.mobile_number = null;
						this.password = null;
						this.password_confirmation = null;
						swal.fire("Process: ", "Please Verify Your Email First To Proceed", "Success")
							.then(res => {
								window.location.href = response.data.url;
							});
					}) 
					.catch(errors => {
						this.isLoading = false;					
						var message = this.parseResponse(errors, 'error');					
						swal.fire("Ooops", message , "error");

					})
			},
	    },

		components: {
			'text-field' : TextField,
			'password-field' : PasswordField,
			'contact-number' : ContactNumber,
			'terms-modal' : TermsModal,
			 Loading
		},

    mixins: [ CrudMixin, ArrayHelpers, ErrorResponse ],

	}
</script>