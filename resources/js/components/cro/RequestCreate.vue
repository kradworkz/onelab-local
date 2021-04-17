<template>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Request Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  @click="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form  @submit.prevent="create" v-if="addcon == false">
                <div class="modal-body">
                    <div class="row" style="margin-right: 10px; margin-left: 10px;">
                        
                        <div class="col-md-12" style="margin-top: 15px;">
                            
                             <div class="form-group row customerform">
                                <div class="col-sm-12">
                                    <div class="form-group form-primary">
                                        <label class="float-label" v-bind:style="errors.customer ? 'color: red' : ''">Customer</label>
                                        <multiselect v-model="customer" id="ajax" label="name" track-by="name"
                                            placeholder="Search Customer" open-direction="bottom" :options="customers"
                                            :searchable="true" @input="onChangeCustomer(customer.customer_id)" @remove="test"
                                            @search-change="asyncFind">
                                        </multiselect> 
                                    </div>
                                </div>

                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group form-primary">
                                                <label class="float-label" v-bind:style="errors.conforme ? 'color: red' : ''">Conforme</label>
                                                <multiselect v-model="conforme" :options="conformes" placeholder="Select Conforme" label="name" track-by="id">
                                                </multiselect>
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <button :disabled="addc" @click="addConforme" style="left:-10px; margin-top: 20px;" type="button" class="btn btn-danger btn-rounded waves-effect waves-light">+</button>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-primary">
                                                <label class="float-label" v-bind:style="errors.laboratory ? 'color: red' : ''">Laboratory</label>
                                                <multiselect v-model="laboratory" :options="laboratories" placeholder="Select Laboratory" label="name" track-by="id">
                                                </multiselect>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group row customerform">
                                <div class="col-sm-6">
                                    <div class="form-group form-primary">
                                        <label class="float-label" v-bind:style="errors.purpose ? 'color: red' : ''">Purpose</label>
                                        <multiselect v-model="purpose" :options="purposes" placeholder="Select Purpose" label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-primary">
                                        <label class="float-label" v-bind:style="errors.duedate ? 'color: red' : ''">Due Date</label>
                                        <input type="date" v-model="duedate" class="form-control">
                                    </div>
                                </div>
                            </div>
                            

                            <div class="form-group row customerform">
                                <div class="col-sm-6">
                                    <div class="form-group form-primary">
                                        <label class="float-label" v-bind:style="errors.discount ? 'color: red' : ''">Discount</label>
                                        <multiselect :custom-label="nameWithLang" v-model="discount" :options="discounts" placeholder="Select Discounts" label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-primary">
                                        <label class="float-label" v-bind:style="errors.mode ? 'color: red' : ''">Mode of Release</label>
                                        <multiselect v-model="mode" :options="modes" placeholder="Select Mode of release" label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Save changes</button>
                    <button type="button" @click="close" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </form>

            <form  @submit.prevent="createconforme" v-else>
               <div class="modal-body">
                    <div class="row" style="margin-right: 10px; margin-left: 10px;">
                        <div class="col-md-12" style="margin-top: 15px;">
                            <div class="custom-control custom-checkbox mb-4">
                                <input type="checkbox" class="custom-control-input" @click="check" id="customCheck1">
                                <label class="custom-control-label text-info" for="customCheck1">Do you want to use your current customer name and mobile?</label>
                            </div>
                            <div class="row customerform">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Name<code v-if="errors.name">({{ errors.name[0] }})</code></label>
                                        <input placeholder="Enter fullname" class="form-control" v-model="con.name" style="text-transform: capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Mobile <code v-if="errors.mobile">({{ errors.mobile[0] }})</code></label>
                                        <input placeholder="Enter Mobile number" class="form-control" v-model="con.mobile" style="text-transform: capitalize;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>

                <div class="modal-footer">
                    <button type="button" @click="addcon = false" class="btn btn-default waves-effect">Close</button> 
                    <button type="submit" class="btn btn-primary waves-effect waves-light "><span>Save</span></button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['agncy','selectedrequest','typeid'],
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                duedate: '',
                laboratory: {id: ''},
                purpose: {id: ''},
                from: {id: '' },
                customer: '',
                conforme: {id: ''},
                discount: {id: ''},
                mode : {id: ''},
                con : {name : '', mobile: '' },
                types: [],
                laboratories: [],
                purposes: [],
                customers: [],
                froms: [],
                conformes: [],
                discounts : [],
                modes : [],
                edit: false,
                addc : true,
                addcon: false
            }
        },

        created() {
            this.fetchPurpose();
            this.fetchMode();
            this.fetchDiscount();   
        },

        watch : {
            selectedrequest: {
                handler: function() {
                    this.view();
                },
                immediate: true,
            },
        },

        methods: {
            nameWithLang ({ name, percentage }) {
                return `${name} - ${percentage}%`;
            },
            checkType(type){
                (type == 81 ) ? this.fetchReferral() : this.fetchLocal();
            },

            fetchLocal() {
                axios.get(this.currentUrl + '/request/admin/dd/active/' + 'Laboratory')
                .then(response => {
                    this.laboratories = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchReferral() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Laboratory')
                .then(response => {
                    this.laboratories = response.data.data;
                })
                .catch(err => console.log(err));
            },
            
            fetchPurpose() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Purpose')
                .then(response => {
                    this.purposes = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchFrom() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Request From')
                .then(response => {
                    this.froms = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchDiscount() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Discount')
                .then(response => {
                    this.discounts = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchMode() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Mode of Release')
                .then(response => {
                    this.modes = response.data.data;
                })
                .catch(err => console.log(err));
            },

            asyncFind(value) {
              
                axios.post(this.currentUrl + '/request/cro/customerbranch/search', {
                    word: value,
                })
                .then(response => {
                    this.customers = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchConforme(id) {
                axios.get(this.currentUrl + '/request/cro/conforme/' + id)
                .then(response => {
                    this.conformes = response.data.data;
                    if(this.conformes.length > 0){
                        this.conforme = this.conformes[0];
                    }
                    this.addc = false;
                })
                .catch(err => console.log(err));
            },

            onChangeCustomer(id) {
                this.conforme = '';
                this.fetchConforme(id);
                this.addc = false;
            },

            onRemoveCustomer(){
                (this.customer != '') ? this.addc = true : this.addc = false;
            },

            addConforme(){
                this.addcon = true;
            },

            create(){
                if (this.edit === false) {
                    axios.post(this.currentUrl + '/request/cro/request/store', {
                        duedate: this.duedate,
                        type: this.typeid,
                        laboratory: this.laboratory.id,
                        purpose: this.purpose.id,
                        from: 94,
                        customer: this.customer.id,
                        conforme: this.conforme.id,
                        mode: this.mode.id,
                        discount: this.discount.id,
                        agency: this.agncy
                    })
                    .then(response => {
                        this.$emit('status', true);
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
                }else{
                    axios.put(this.currentUrl + '/request/cro/request/store', {
                        id: this.id,
                        duedate: this.duedate,
                        type: this.type.id,
                        laboratory: this.laboratory.id,
                        purpose: this.purpose.id,
                        from: this.from.id,
                        customer: this.customer.id,
                        conforme: this.conforme.id,
                        agency: this.agncy
                    })
                    .then(response => {
                        this.$emit('status', true);
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
                }
            },

            createconforme(){
                if (this.edit === false) {
                    axios.post(this.currentUrl + '/request/cro/conforme/store', {
                        name: this.con.name,
                        mobile: this.con.mobile,
                        customer: this.customer.customer_id
                    })
                    .then(response => {
                        this.addcon = false;
                        this.fetchConforme(this.customer.customer_id);
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
                }else{
                    axios.put(this.currentUrl + '/request/cro/conforme/store', {
                        id: this.con.id,
                        name: this.con.name,
                        mobile: this.con.mobile,
                        customer: this.customer.customer_id
                    })
                    .then(response => {
                        this.$emit('status', true);
                    })
                    .catch(error => {
                        if (error.response.status == 422) {
                            this.errors = error.response.data.errors;
                        }
                    });
                }
            },

            view(){
                (this.selectedrequest.id != null) ? this.edit = true : this.edit = false;
                this.id = this.selectedrequest.id;
                this.duedate = this.selectedrequest.duedate;
                this.purpose = this.selectedrequest.purpose;
                this.type = this.selectedrequest.type;
                this.from = this.selectedrequest.from;
                this.discount = this.selectedrequest.discount;
                this.mode = this.selectedrequest.mode;
                this.customer = this.selectedrequest.customer;
                this.conforme = this.selectedrequest.conforme;
            },

            close(){
                this.edit = false;
            },

            test(){
                this.customer = {};
            },

            check : function(event) {
                if (event.target.checked) {
                    this.con.name = this.customer.name;
                    this.con.mobile = this.customer.mobile;
                }else{
                    this.con.name = '';
                    this.con.mobile = '';
                }
            }
            

        },
        components: { Multiselect }
    }

</script>