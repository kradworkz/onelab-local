<template>
    <div class="modal-dialog modal-dialog-centered modal" role="document">
        <div class="modal-content">
            
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Login API</h5>
            </div>

            <div class="modal-body">
                
                <div class="card-body pt-0"> 
                    <div class="p-2 mt-4">
                        <form class="form-horizontal" @submit.prevent="login">

                            <div class="form-group">
                                <label for="userpassword">Email</label>
                                <input type="text" class="form-control" v-model="email" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="userpassword">Password</label>
                                <input type="password" class="form-control" v-model="password" placeholder="Enter password">
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-12 text-right">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Confirm</button>
                                    <a href="/requests" class="btn btn-warning waves-effect waves-light" type="button">Back</a>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
                
                <div class="mt-5 text-center">
                    <p>© 2021 Onelab. Crafted with <i class="mdi mdi-heart text-danger"></i> by Krad</p>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            currentUrl: window.location.origin,
            errors: [],
            email: '',
            password: ''
        }
    },

    methods : {
        login(){
            axios.post('https://one.main/api/login', {
                email: this.email,
                password: this.password,
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if(response.data.status_code == 200){
                    Vue.$toast.success('<strong>Login Successful!</strong>', {
                        position: 'bottom-left'
                    });
                    localStorage.setItem('api_token', response.data.access_token);
                    // let toks = localStorage.getItem('api_token');
                    $("#loginapi").modal('hide');
                    this.$parent.check(true);
                }else{
                    Vue.$toast.error('<strong>'+response.data.message +'</strong>', {
                        position: 'bottom-left'
                    });
                }
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        }
    }
}
</script>
