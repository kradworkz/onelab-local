<template>
    <div>

        <div class="row" v-if="referral == false">
            <div class="col-xl-4">
                <div class="card overflow-hidden">
                    <div class="bg-soft-primary">
                        <div class="row">
                            <div class="col-12">
                                <div class="text-primary p-3">
                                    <h5 class="text-primary" style="margin-bottom: 0px;">{{ viewrequest.customer }}</h5>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-sm-8 mt-3">
                                <h5 class="font-size-15 text-truncate">{{ viewrequest.conforme }} <span class="badge badge-soft-success font-size-10"> (Conforme) </span></h5>
                                <p class="text-muted mb-0 text-truncate">{{ viewrequest.mobile }} <span class="badge badge-soft-success font-size-10"> (Mobile) </span></p>
                            </div>
                            <div class="col-sm-4 mt-3">
                                <h5 class="font-size-14"><i class="bx bx-calendar-check mr-1 text-primary"></i> Due Date</h5>
                                <p class="text-muted mb-0">{{ viewrequest.due_at }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div v-if="viewrequest.status == 'Pending'">
                            <div class="alert alert-warning" role="alert">
                                Upon saving, Samples and Analysis are not editable anymore.
                            </div>
                            <div class="text-right">
                                <a class="btn btn-outline-light mr-2 w-md">Cancel</a>
                                <button :disabled="count" @click="save" class="btn btn-primary mr-2 w-md">Save Request</button>
                            </div>
                            <hr>
                        </div>
                        <h4 class="card-title mb-4">Request Information</h4>

                        <div class="table-responsive">
                            <table class="table table-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Laboratory :</th>
                                        <td>{{ viewrequest.laboratory }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Purpose :</th>
                                        <td>{{ viewrequest.purpose }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">From :</th>
                                        <td>{{ viewrequest.from }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Discount :</th>
                                        <td>{{ viewrequest.discount }}</td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Received By :</th>
                                        <td>{{ viewrequest.receive }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-8">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-xs mr-3">
                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                            <i class="bx bx-copy-alt"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-12 mb-0">Request Details</h5>
                                </div>
                                <div class="text-muted">
                                    <h4 class="font-size-16">{{ viewrequest.reference }}</h4>
                                    <div class="d-flex">
                                        <span v-if="viewrequest.status == 'Pending'" class="badge badge-warning font-size-12"> {{ viewrequest.status }} </span>
                                        <span v-else-if="viewrequest.status == 'Confirmed'" class="badge badge-primary font-size-12"> {{ viewrequest.status }} </span>
                                        <span v-else-if="viewrequest.status == 'Cancelled'" class="badge badge-danger font-size-12"> {{ viewrequest.status }} </span>
                                        <span v-else-if="viewrequest.status == 'Waiting'" class="badge badge-info font-size-12"> {{ viewrequest.status }} </span>
                                        <span v-else-if="viewrequest.status == 'Ongoing'" class="badge badge-info font-size-12"> {{ viewrequest.status }} </span>
                                        <span v-else class="badge badge-success font-size-12"> {{ viewrequest.status }} </span>
                                        <span class="ml-2 text-truncate" data-toggle="tooltip" data-placement="top" title="" data-original-title="Requested Date"><i class="bx bx-calendar mr-1"></i>{{ viewrequest.created_at }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-xs mr-3">
                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                            <i class="bx bx bx-detail"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-12 mb-0">Transaction Details</h5>
                                </div>
                                <div class="text-muted">
                                    <h4 class="font-size-16">{{ viewrequest.transaction_no }}</h4>
                                    <div class="d-flex">
                                        <span v-if="viewrequest.transaction_status == 'Paid'" class="badge badge-soft-success font-size-12"> {{ viewrequest.transaction_status }} </span>
                                        <span v-else class="badge badge-warning font-size-12"> {{ viewrequest.transaction_status }} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="avatar-xs mr-3">
                                        <span class="avatar-title rounded-circle bg-soft-primary text-primary font-size-18">
                                            <i class="bx bx-purchase-tag-alt"></i>
                                        </span>
                                    </div>
                                    <h5 class="font-size-12 mb-0">Payment Details</h5>
                                </div>
                                <div class="text-muted">
                                    <h4 class="font-size-16">{{ viewrequest.or_receipt}}</h4>
                                    
                                    <div class="d-flex">
                                       <span class="text-truncate"> <i class="bx bx-calendar mr-1"></i>{{ viewrequest.or_date}} </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <request-sample :agencyid="agency" :lab="viewrequest.laboratory_id" :status="viewrequest.status" :reqsid="reqid" :type="viewrequest.type" @done="finished" ref="updatesamples"></request-sample> 
                                <request-analysis :percentage="viewrequest.percentage" :status="viewrequest.status" :reqsid="reqid" ref="updateanalysis" @analysiscount="checked"></request-analysis>                                                     
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div v-else>
            <div class="row justify-content-center">
                    <div class="col-md-6 col-lg-6 ">
                        <div class="card overflow-hidden">
                            <div class="bg-soft-primary">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Login</h5>
                                            <p>Enter your password to access Api!</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                              
                                <div class="p-2 mt-4">
                                    <form class="form-horizontal" @submit.prevent="loginapi">

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
                                                <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Unlock</button>
                                            </div>
                                        </div>
    
                                    </form>
                                </div>
            
                            </div>
                        </div>
                        <div class="mt-5 text-center">
                            <p>© 2021 Onelab. Crafted with <i class="mdi mdi-heart text-danger"></i> by Krad</p>
                        </div>

                    </div>
                </div>
        </div>

    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
export default {
    props: ['reqid','agency'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            viewrequest : {},
            count : true,
            referral : false,
            email: '',
            password: '',
        }
    },

    created(){
        this.fetch();
    },

    methods : {
        fetch(){
            axios.get(this.currentUrl + '/request/cro/request/'+this.reqid)
            .then(response => {
                this.viewrequest = response.data.data;
                (this.viewrequest.type == 'Referral') ? this.$parent.validateToken() : this.referral = false;
            })
            .catch(err => console.log(err));
        },

        save(){
            (this.viewrequest.type == 'Referral') ?  this.$parent.validateToken() : this.referral = false;

            axios.post(this.currentUrl + '/request/cro/request/update', {
                id: this.reqid,
                token: localStorage.getItem('api_token')
            })
            .then(response => {
                Vue.$toast.success('<strong>Request Saved</strong>', {
                    position: 'bottom-left'
                });
                this.fetch();
                this.$refs.updatesamples.fetchSamples(this.reqid);
                this.$refs.updateanalysis.fetchAnalyses(this.reqid);
                this.$refs.updateanalysis.fetchPackages(this.reqid);
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        finished(status) {
            this.$refs.updateanalysis.fetchAnalyses(this.reqid);
            this.$refs.updateanalysis.fetchPackages(this.reqid);
        },

        checked(count){
            (count > 0) ? this.count = false : this.count = true;
        },
        
        validateToken(){
            let toks = localStorage.getItem('api_token');

            axios.get('https://one.main/api/check',{
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization' : `Bearer ${toks}`
                }
            })
            .then(response => {
                this.referral = false;
            })
           .catch(error => {
                if (error.response.status == 401) {
                    this.referral = true;
                }
            });
        },

        loginapi(){
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
                    this.referral = false;
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

    },  components: { Multiselect }
}
</script>
