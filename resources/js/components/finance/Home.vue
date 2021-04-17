
<template>
<div>

    <div v-if="show == false">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <div class="avatar-md mx-auto mb-4">
                                <div class="avatar-title bg-light rounded-circle text-primary h1">
                                    <i class="mdi mdi-cash-register"></i>
                                </div>
                            </div>

                            <div class="row justify-content-center mb-4">
                                <div class="col-xl-10">
                                    <h4 class="text-primary">Search Customer!</h4>
                                    <p class="text-muted font-size-14 mb-4">Search Customer name that you would wish to make transaction</p>

                                    <div style="width: 100%;">
                                        <multiselect v-model="customer" id="ajax" label="name" track-by="name"
                                            placeholder="Search Customer" open-direction="bottom" :options="customers"
                                            :searchable="true" @input="onChangeCustomer(customer.id)" @remove="test"
                                            @search-change="asyncFind">
                                        </multiselect> 
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">s</div>
            </div>
        </div>
    </div>

    <div v-else>
        <div  class="row">
            <div class="col-md-8">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="media">
                                        <div class="media-body align-self-center">
                                            <div class="text-muted">
                                                <h5 class="mb-1">{{customer.name}}</h5>
                                                <p class="mb-0">{{customer.address}} | {{customer.mobile}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-lg-4 d-none d-lg-block">
                                    <div class="clearfix  mt-4 mt-lg-0">
                                        <div class="text-muted float-right">
                                            <h5 class="mb-1">{{ transaction.transaction_no}}</h5>
                                            <p class="mb-0"> {{ transaction.updated_at }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive" v-if="requests.length > 0">
                                <table class="table table-nowrap">
                                    <thead>
                                        <tr>
                                            <th style="width: 70px;">No.</th>
                                            <th>Reference #</th>
                                            <th  class="text-right">Subtotal</th>
                                            <th  class="text-right">Discount</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="request in requests" v-bind:key="request.id">
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input :id="'customCheck_' + request.id" type="checkbox" :value="request" v-model="checkbox" class="custom-control-input" checked/>
                                                    <label class="custom-control-label" :for="'customCheck_' + request.id">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{request.reference}}</td>
                                            <td class="text-right">₱{{request.subtotal}}</td>
                                            <td class="text-right">₱{{request.discount}}</td>
                                            <td class="text-right">₱{{request.total}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4" class="border-0 text-right"><strong>Total</strong></td>
                                            <td class="border-0 text-right"><h4 class="m-0">₱{{ formatPrice(total)}}</h4></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div v-else>
                                <div class="mt-auto">
                                    <div class="alert alert-success alert-dismissible fade show px-3 mb-0" role="alert">
                                        <div class="mb-3">
                                            <i class="bx bxs-folder-open h1 text-success"></i>
                                        </div>
                                        <div class="mb-3">
                                            <h5 class="text-success">Nothing found.</h5>
                                            <p>No Pending transaction for this Customer.</p>
                                            <div class="text-center">
                                                <button type="button" @click="back" class="btn btn-link text-decoration-none text-success">Go Back <i class="mdi mdi-arrow-right"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-4">
                        <form @submit.prevent="paynow" v-if="p == false">
                            <multiselect style="margin-bottom: 5px;" v-model="customer" id="ajax" label="name" track-by="name"
                                placeholder="Search Customer" open-direction="bottom" :options="customers"
                                :searchable="true" @input="onChangeCustomer(customer.id)" @remove="test"
                                @search-change="asyncFind">
                            </multiselect>

                            <multiselect style="margin-bottom: 5px;" v-model="payment" :options="payments"
                                placeholder="Select Payment Mode" label="name" @input="onChangePayment(payment.name)" track-by="id">
                            </multiselect>

                            <multiselect style="margin-bottom: 5px;" v-model="deposit" :options="deposits"
                                placeholder="Select Deposit Type" label="name" track-by="id">
                            </multiselect>

                            <div v-if="cheque == true">
                                <hr>
                                <div class="form-group customerform">
                                    <label class="float-label">Bank Name <code style="color: red;" v-if="errors.bank">({{ errors.name[0] }})</code></label>
                                    <input placeholder="Enter bank name" type="text" v-model="bank" class="form-control" style="text-transform:capitalize;">
                                    <label class="float-label">Cheque Number <code style="color: red;" v-if="errors.number">({{ errors.number[0] }})</code></label>
                                    <input placeholder="Enter cheque number" type="text" v-model="number" class="form-control" style="text-transform:capitalize;">
                                    <label class="float-label">Amount <code style="color: red;" v-if="errors.amount">({{ errors.amount[0] }})</code></label>
                                    <input placeholder="Enter amount" type="text" v-model="amount" class="form-control" style="text-transform:capitalize;">
                                    <label class="float-label" v-bind:style="errors.duedate ? 'color: red' : ''">Cheque Date</label>
                                    <input type="date" v-model="chequedate" class="form-control">
                                </div>
                                <hr class="mb-4 mt-4">
                            </div>
                            
                            <button type="submit" :disabled="clickable" class="btn waves-effect waves-light btn-info btn-square">Pay now</button>
                        </form>
                        <div v-else>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="mdi mdi-check-all mr-2"></i>
                                Payment Successful!
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">×</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {

        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                transaction: {},
                requests: [],
                payments: [],
                deposits : [],
                customers: [],
                customer: '',
                deposit: '',
                payment: '',
                show : false,
                checkbox: [],
                number : '',
                amount : '',
                bank: '',
                chequedate: '',
                tot: 0,
                clickable : true,
                p : false,
                cheque : false,

            }
        },
        
        computed: {
            total() {
                return this.checkbox.reduce((a, req) => {
                    this.tot = parseInt(a) + parseInt(req.total.replace(/,/g, ''));
                    return this.tot;
                }, 0);
            }
        },

        methods : {
            asyncFind(value) {
              
                axios.post(this.currentUrl + '/request/cro/customerbranch/search', {
                    word: value,
                })
                .then(response => {
                    this.customers = response.data.data;
                })
                .catch(err => console.log(err));
            },

            onChangeCustomer(id) {
                this.getTransaction(id);
                this.getRequest(id);
                this.fetchPayment();
                this.fetchDeposit();
                this.show = true;
            },
            

            getRequest(id) {
                axios.get(this.currentUrl + '/request/finance/requests/' + id)
                .then(response => {
                    this.requests = response.data.data;
                    Object.entries(this.requests).forEach(([key, val]) => {
                        this.checkbox.push(val);
                    });

                    (this.requests.length > 0) ? this.clickable = false : this.clickable = true;
                })
                .catch(err => console.log(err));
            },

            getTransaction(id) {
                axios.get(this.currentUrl + '/request/finance/transaction/' + id)
                .then(response => {
                    this.transaction = response.data.data;
                    if(Object.keys(this.transaction).length === 0){
                        this.view = false;
                    }else{
                        this.view = true;
                    }
                })
                .catch(err => console.log(err));
            },

            fetchPayment() {
                axios.get(this.currentUrl + '/request/admin/dd/active/Payment Mode')
                .then(response => {
                    this.payments = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchDeposit() {
                axios.get(this.currentUrl + '/request/admin/dd/active/Deposit Type')
                .then(response => {
                    this.deposits = response.data.data;
                })
                .catch(err => console.log(err));
            },

            onChangePayment(type) {
               (type == 'Cheque') ? this.cheque = true : this.cheque = false;
            },


            paynow() {
                axios.post(this.currentUrl + '/request/finance/payment', {
                    transaction: this.transaction.id,
                    payment: this.payment.id,
                    deposit: this.deposit.id,
                    lists: this.checkbox,
                    payment_type: this.payment.name,
                    bank : this.bank,
                    number: this.number,
                    amount: this.amount,
                    chequedate: this.chequedate
                })
                .then(response => {
                    Vue.$toast.success('<strong>Payment Successful!</strong>', {
                        position: 'bottom-left'
                    });
                    this.p = true;
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            test(){

            },

            back(){
                this.show = false;
                this.customer = '';
            },

            formatPrice(value) {
                let val = (value/1).toFixed(2).replace(',', '.')
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            },
        },
        components: { Multiselect }
    
    }
</script>