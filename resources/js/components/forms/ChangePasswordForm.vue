<template>
  <form @submit.prevent="processForm">  
        <card>
            
            <template v-slot:header>Change Password</template>

            <div class="row">
                <password
                class="form-group col-sm-12"
                label="Current Password"
                name="current_password"
                v-model="item.current_password"
                placeholder="Current Password"
                ></password>
            </div>

            <div class="row">
                <password
                class="form-group col-sm-12 col-md-6"
                label="New Password"
                name="new_password"
                v-model="item.new_password"
                placeholder="New Password"
                ></password>

                <password
                class="form-group col-sm-12 col-md-6"
                label="Confirm New Password"
                name="new_password_confirmation"
                v-model="new_password_confirmation"
                placeholder="Confirm New Password"
                ></password>
            </div>
            
            <template v-slot:footer>
                <action-button type="submit" :loading="loading" :disabled="loading" class="btn-primary">Change Password</action-button>
            </template>
        </card>

    </form>
</template>

<script type="text/javascript">
import CrudMixin from '../../mixins/crud.js';
import Loading from 'vue-loading-overlay';
import ErrorResponse from 'Mixins/errorResponse';
import 'vue-loading-overlay/dist/vue-loading.css'; 

import Password from '../inputs/Password.vue';

export default {
	components: {
		'password': Password,
         Loading
        
	},

    mixins: [ CrudMixin, ErrorResponse ],
}
</script>