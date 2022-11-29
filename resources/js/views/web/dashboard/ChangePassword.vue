<template>
  <form @submit.prevent="processForm">	
	<div class="frm-cntnr">
		<div class="w-90 mx-auto">
			<p class="mb-3 font-weight-bold text-primary">CHANGE PASSWORD</p>
			<p>Leave the fields empty if you wish to reatain your password</p>

			<div class="w-60">
				<div class="row">
					<div class="col-12">
						<div class="form-group">
							<label>Current Password</label>
							<div class="input-group">
								<input v-model="old_password" placeholder="Current Password" :type="hidden.old_password ? 'password' : 'text'" class="form-control">
								<div class="input-group-append">
					                <button type="button" @click="hidden.old_password = !hidden.old_password" class="btn btn-light border">
										<i v-if="hidden.old_password" class="fa fa-eye-slash"></i>
										<i v-if="!hidden.old_password" class="fa fa-eye"></i>
									</button>
					            </div>
							</div>
						</div>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-sm-12 col-12">
						<div class="form-group">
							<label>New Password</label>
							<div class="input-group">
								<input v-model="new_password" placeholder="New Password" :type="hidden.new_password ? 'password' : 'text'" class="form-control">
								<div class="input-group-append">
					                <button type="button" @click="hidden.new_password = !hidden.new_password" class="btn btn-light border">
										<i v-if="hidden.new_password" class="fa fa-eye-slash"></i>
										<i v-if="!hidden.new_password" class="fa fa-eye"></i>
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

				<div class="row mt-5">
					<div class="col-12">
						<button type="submit" class="btn btn-primary rounded-btn font-weight-bold">SAVE & UPDATE</button>
					</div>
				</div>
				<loading :active.sync="isLoading" 
				         :is-full-page="fullPage"
				         color="#e8627c"
				         ></loading>

			</div>
		</div>
	</div>
  </form>	
</template>

<script>
import CrudMixin from '../../../mixins/crud.js';
import ArrayHelpers from '../../../mixins/array.js';
import Loading from 'vue-loading-overlay';
import ErrorResponse from 'Mixins/errorResponse';
import 'vue-loading-overlay/dist/vue-loading.css'; 

import PasswordField from '../../../components/inputs/Password.vue';

export default {

    data() { 
      return {
		old_password: null,
		new_password: null,
		password_confirmation: null,      	
		isLoading: false,
        fullPage: true,
	        hidden: {
	        	old_password: true,
	        	new_password: true,
	        	password_confirmation: true,
	        }
        }
    },    


    methods: {
    	
		processForm() {

			this.isLoading = true;
			
			var data = {
				old_password: this.old_password,	
				new_password: this.new_password,				
				password_confirmation: this.password_confirmation,

			}

			axios.post(this.submitUrl, data)		
				.then(response => {
					this.isLoading = false;
					this.old_password = null,
					this.new_password = null,
					this.password_confirmation = null,
					swal.fire("Process: ", "Password Successfully Changed!", "success");
				})
				.catch(errors => {
					this.isLoading = false;					
					var message = this.parseResponse(errors, 'error');
					swal.fire("Ooops", message , "error");
				})
		},

    },
	
	components: {
		'password-field' : PasswordField,
		 Loading
	},

    mixins: [ CrudMixin, ArrayHelpers, ErrorResponse ],

}
</script>