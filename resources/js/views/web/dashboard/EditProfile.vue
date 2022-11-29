<template>
  <form @submit.prevent="processForm">	
	<div class="frm-cntnr edit--profile">
		<div class="w-90 mx-auto">
			<p class="font-weight-bold text-primary">EDIT PROFILE</p>

			<div class="w-100">
				<div class="w-30 text-center">			

 				<div>
 				<img class="mr-2 edit--img mx-auto mb-4" :src="item.image_path"/>

 				</div>
					<div>
					  <label class="btn btn-light-brown px-3 py-0 rounded-btn"><small class="text-white"><i class="fas fa-camera-retro"></i> Update Profile Picture </small>
				        <input style="display: none" name="image_path" type="file" id="file" ref="file" accept="image/*" v-on:change="handleFileUpload()"/>
				      </label>
				    </div>
				</div>
			</div>

			<div class="w-60">
				<div class="row mt-5">
					<div class="col-md-6 col-sm-12 col-12">
						<text-field
						label="First Name"
					    name="first_name"
					    v-model="item.first_name"
					    @keypress="regexString()"
					    required						
						></text-field>
					</div>

					<div class="col-md-6 col-sm-12 col-12">
						<text-field
						label="Last Name"
						name="last_name"		
					    v-model="item.last_name"
					    @keypress="regexString()"										
						required
						></text-field>
					</div>
				</div>

				<div class="row">
					<div class="col-md-6 col-sm-12 col-12">
						<text-field
						label="Email"
						name="email"
					    v-model="item.email"	
					    disabled
						></text-field>
					</div>
				</div>

				<div class="row mb-3">
					<div class="col-12">
					<contact-number
						label="Mobile Number"
						name="mobile_number"
					    v-model="item.mobile_number"	
						@keypress="regexNumber()"					    
					    required		
					></contact-number>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<button type="submit" class="btn btn-primary rounded-btn font-weight-bold">SAVE & UPDATE</button>
					</div>
				</div>	
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
import CrudMixin from 'Mixins/crud.js';
import ArrayHelpers from 'Mixins/array.js';
import ResponseMixin from 'Mixins/response.js';
import ActionButton from 'Components/buttons/ActionButton.vue';
import Loading from 'vue-loading-overlay';
import ErrorResponse from 'Mixins/errorResponse';
import 'vue-loading-overlay/dist/vue-loading.css'; 
import RegexValidation from 'Mixins/regex.js';



import TextField from 'Components/inputs/TextField.vue';
import NumberField from 'Components/inputs/NumberField.vue';
import ContactNumber from 'Components/inputs/ContactNumber.vue';

	export default {
	props: {
		submitUrl: String
	},

	components: {
		'text-field' : TextField,	
		'number-field' : NumberField,
		'contact-number': ContactNumber,
		'action-button': ActionButton,
		Loading
	
	},

	/*
      Defines the data used by the component
    */
   
    data() { 
      return {
		item: {},      	
        file: '',
        showPreview: false,
        imagePreview: '',
		isLoading: false,
        fullPage: true
        }
    },    

    mixins: [ CrudMixin, ArrayHelpers, ErrorResponse ],


	methods: {

		fetchSuccess(data) {	
			this.item = data.item ? data.item : this.item;
		},

        /*
         Handles a change on the file upload
       */
    	handleFileUpload(){
        /*
          Set the local file variable to what the user has selected.
        */
        	this.file = this.$refs.file.files[0];

        /*
          Initialize a File Reader object
        */
       	 	let reader  = new FileReader();

        /*
          Add an event listener to the reader that when the file
          has been loaded, we flag the show preview as true and set the
          image to be what was read from the reader.
        */
	        reader.addEventListener("load", function () {
		          this.showPreview = true;
		          this.item.image_path = reader.result;
		        }.bind(this), false);

        /*
          Check to see if the file is not empty.
        */
	        if( this.file ){
          /*
            Ensure the file is an image file.
          */
    	      if ( /\.(jpe?g|png|gif)$/i.test( this.file.name ) ) {
            /*
              Fire the readAsDataURL method which will read the file in and
              upon completion fire a 'load' event which we will listen to and
              display the image in the preview.
            */
        	    reader.readAsDataURL( this.file );
        	  }
           }
        },

		processForm() {

			this.isLoading = true;
			let data = new FormData;
			data.append("image_path", this.file);
			data.append("first_name", this.item.first_name);
			data.append("last_name", this.item.last_name);
			data.append("email", this.item.email);
			data.append("mobile_number", this.item.mobile_number);

			axios.post(this.submitUrl, data)		
				.then(response => {
					this.isLoading = false;
					swal.fire({
						title:"Process:",
						icon: "success",
						html:"Profile Successfully Updated!!!",
						onClose: () => {
							window.location.reload();
						},
					});
				})
				.catch(errors => {
					this.isLoading = false;
					var message = this.parseResponse(errors, 'error');
					swal.fire("Ooops", message , "error");
				})
		},

	},

}
</script>