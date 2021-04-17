<template>
    <div>
        <form class="form-horizontal" @submit.prevent="changepassword">
            <div class="user-thumb text-center mb-1">
                <img src="" class="rounded-circle img-thumbnail avatar-md" alt="thumbnail">
                <h5 class="font-size-15 mt-3"></h5>
            </div>


            <div class="form-group">
                <label for="userpassword">Current Password <b v-if="test" style="color: red; font-size: 12px;"> ({{ test }})</b></label>
                <input type="password" class="form-control" v-model="current_password" placeholder="Enter password">
            </div>
               <div class="form-group">
                <label for="userpassword">New Password <b v-if="errors.password" style="color: red; font-size: 12px;"> ({{ errors.password[0] }})</b></label>
                <input type="password" class="form-control" v-model="password" placeholder="Enter password">
                <input type="password" class="form-control" v-model="password_confirmation" placeholder="Enter password" style="margin-top: 5px;">
            </div>

            <div class="form-group row mb-0">
                <div class="col-12 text-right">
                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Unlock</button>
                </div>
            </div>

        </form>
     </div>
</template>
<script>
export default {
    data(){
        return{
            currentUrl: window.location.origin,
            errors: [],
            current_password : '',
            password : '',
            password_confirmation: '',
            test: '',
            test1: ''
        }
    },

    methods : {
        changepassword(){
            axios.post(this.currentUrl + '/request/user/password', {
                current_password: this.current_password,
                password: this.password,
                password_confirmation: this.password_confirmation,
            })
            .then(response => {
                if(response.data.success == "First Attempt"){
                    window.location.replace('/home');
                }else{
                    this.current_password = '';
                    this.password = '';
                    this.password_confirmation = '';
                    alert(response.data.success);
                }
            })
            .catch(error => {
                if (error.response.status == 422) {
                   this.errors = error.response.data.errors;
                } 
                
                if(error.response.status == 401){
                   this.test = error.response.data.error;
                }
            });
        }
    }
}
</script>