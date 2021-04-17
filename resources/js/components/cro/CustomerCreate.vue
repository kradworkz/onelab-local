
<template>
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Customer Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"  @click="close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            
            <form @submit.prevent="create">
                <div class="modal-body">
                    <div class="row" style="margin-right: 10px; margin-left: 10px;">
                        
                        <div class="col-md-12" style="margin-top: 15px;" v-if="viewnew == false">
                            <div class="text-center">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10">
                                        <h4 class="mt-4 font-weight-semibold">Search Customer</h4>
                                        <p class="text-muted mt-3">If you wish to add a new branch of an existing customer. Use the search bar and select it. <br> If you want new click "Add new Customer".</p>
                                         <div class="row customerform mb-4">
                                            <div class="col-md-12">
                                                <multiselect v-model="custom" id="ajax" label="name" track-by="name"
                                                    placeholder="Search Customer" open-direction="bottom" :options="customs"
                                                    :searchable="true"  @input="onChangeCustomer(custom)" 
                                                    @search-change="asyncFind">
                                                </multiselect> 
                                            </div>
                                        </div>

                                        <div class="mt-4">
                                            <button type="button" class="btn btn-primary" @click="customercheck(true)">
                                                Add New Customer
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 15px;" v-else>
                            <div v-if="newcustomer == true">
                                <multiselect v-model="custom" id="ajax" label="name" track-by="name"
                                    placeholder="Search Customer" open-direction="bottom" :options="customs"
                                    :searchable="true"  @tag="addTag"  @input="onChangeCustomer(custom)" 
                                    @search-change="asyncFind">
                                </multiselect> 
                            </div>
                            <div v-else>
                                <div class="row customerform">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="float-label">Customer Name <code style="color: red;" v-if="errors.name">({{ errors.name[0] }})</code></label>
                                            <input @keyup="clearerrors" placeholder="Enter customer name" type="text" v-model="customer.name" class="form-control" style="text-transform:capitalize;">
                                        </div>
                                        <!-- <label class="float-label">Customer Name <code style="color: red;" v-if="errors.name">({{ errors.name[0] }})</code></label>
                                        <multiselect v-model="custom" id="ajax" label="name" track-by="name"
                                            placeholder="Search Customer" open-direction="bottom" :options="customs"
                                            :searchable="true"  @tag="addTag"  @input="onChangeCustomer(custom)" 
                                            :taggable="true"
                                            @search-change="asyncFind">
                                        </multiselect>  -->
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="formrow-firstname-input">Email <code v-if="errors.email" class="haveerror">({{ errors.email[0] }})</code></label>
                                            <input @keyup="clearerrors" placeholder="Enter valid email address" class="form-control" v-model="customer.email">
                                        </div>
                                    </div>
                                </div>


                                <div class="form-group row customerform">
                                    <div class="col-sm-3">
                                        <div class="form-group form-primary">
                                            <label class="float-label" v-bind:style="errors.province ? 'color: red' : ''">Business Nature</label>
                                            <multiselect v-model="bussiness" :options="bussinesses"
                                                placeholder="Select Business Nature" label="name" track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-primary">
                                            <label class="float-label" v-bind:style="errors.province ? 'color: red' : ''">Industry Type</label>
                                            <multiselect v-model="industry" :options="industries" placeholder="Select Industry"
                                                label="name" track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-primary">
                                            <label class="float-label" v-bind:style="errors.province ? 'color: red' : ''">Customer Type</label>
                                            <multiselect v-model="type" :options="types" placeholder="Select Customer Type"
                                                label="name" track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group form-primary">
                                            <label class="float-label" v-bind:style="errors.province ? 'color: red' : ''">Classification</label>
                                            <multiselect v-model="classification" :options="classifications"
                                                placeholder="Select Customer Type" label="name" track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- <div class="row customerform">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Email <code v-if="errors.email" class="haveerror">({{ errors.email[0] }})</code></label>
                                        <input @keyup="clearerrors" placeholder="Enter valid email address" class="form-control" v-model="customer.email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Mobile <code v-if="errors.mobile" class="haveerror">({{ errors.mobile[0] }})</code></label>
                                        <input @keyup="clearerrors" placeholder="Enter Mobile number" class="form-control" v-model="customer.mobile" style="text-transform: capitalize;">
                                    </div>
                                </div>
                            </div> -->
                            <hr>

                            <div class="form-group row customerform">
                                <div class="col-sm-6">
                                    <div class="form-group form-primary">
                                        <label class="float-label" v-bind:style="errors.province ? 'color: red' : ''">Province</label>
                                        <multiselect @input="onChangeProvince(province.id)" v-model="province"
                                            :options="provinces" placeholder="Select Province" label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group form-primary">
                                        <label class="float-label" v-bind:style="errors.province ? 'color: red' : ''">Municipality</label>
                                        <multiselect v-model="municipality" :options="municipalities"
                                            placeholder="Select Municipality" label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row customerform">
                                <div class="col-sm-6">
                                    <div class="custom-form">
                                        <label class="float-label">Address<code style="color: red;" v-if="errors.address">({{ errors.address[0] }})</code></label>
                                        <input @keyup="clearerrors" placeholder="Enter address" type="text" v-model="customer.address" class="form-control" style="text-transform:capitalize;">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="formrow-firstname-input">Mobile <code v-if="errors.mobile" class="haveerror">({{ errors.mobile[0] }})</code></label>
                                        <input @keyup="clearerrors" placeholder="Enter Mobile number" class="form-control" v-model="customer.mobile" style="text-transform: capitalize;">
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

        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
export default {
    props: ['agencyid','selectedcustomer'],
        data() {
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                customs: [],
                custom: '',
                customer: {
                    id: '',
                    user_id: '',
                    name: '',
                    address: '',
                    email: '',
                    fax: '',
                    mobile: '',
                    tel: ''
                },
                bussiness: {
                    id: ''
                },
                industry: {
                    id: ''
                },
                type: {
                    id: ''
                },
                classification: {
                    id: ''
                },
                region: {
                    id: ''
                },
                province: {
                    id: ''
                },
                municipality: {
                    id: ''
                },
                types: [],
                bussinesses: [],
                industries: [],
                classifications: [],
                provinces: [],
                municipalities: [],
                edit: false,
                viewnew : false,
                newcustomer : false
            }
        },

        created() {
            this.fetchType();
            this.fetchClassification();
            this.fetchBussiness();
            this.fetchIndustry();
            this.fetchProvince();
        },

        // watch : {
        //     selectedcustomer: {
        //         handler: function() {
        //             this.view();
        //         },
        //         immediate: true,
        //     },
        // },

        methods: {

            asyncFind(value) {
                if(value.length > 5){
                    axios.post(this.currentUrl + '/request/cro/customer/search', {
                        word: value,
                    })
                    .then(response => {
                        this.customs = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            },


            fetchBussiness() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Bussiness Nature')
                    .then(response => {
                        this.bussinesses = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            fetchIndustry() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Industry Type')
                    .then(response => {
                        this.industries = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            fetchType() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Customer Type')
                    .then(response => {
                        this.types = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            fetchClassification() {
                axios.get(this.currentUrl + '/request/admin/dd/list/' + 'Classification')
                    .then(response => {
                        this.classifications = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            fetchProvince() {
                axios.get(this.currentUrl + '/request/provinces/' + this.agencyid)
                    .then(response => {
                        this.provinces = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            fetchMunicipality($id) {
                axios.get(this.currentUrl + '/request/municipalities/' + $id)
                    .then(response => {
                        this.municipalities = response.data.data;
                    })
                    .catch(err => console.log(err));
            },

            onChangeRegion($id) {
                this.fetchProvince($id);
                this.customer.province = '';
                this.customer.municipality = '';
            },

            onChangeProvince($id) {
                this.fetchMunicipality($id);
                this.customer.municipality = '';
            },

            create(){
                if (this.edit === false) {
                    if(this.newcustomer == false){
                        axios.post(this.currentUrl + '/request/cro/customer/store', {
                            name: this.customer.name,
                            bussiness: this.bussiness.id,
                            type: this.type.id,
                            industry: this.industry.id,
                            classification: this.classification.id,
                            region: this.agencyid,
                            province: this.province.id,
                            municipality: this.municipality.id,
                            address: this.customer.address,
                            email: this.customer.email,
                            mobile: this.customer.mobile,
                            fax: this.customer.fax,
                            tel: this.customer.tel
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
                        axios.post(this.currentUrl + '/request/cro/customerbranch/store', {
                            id: this.custom.id,
                            region: this.agencyid,
                            province: this.province.id,
                            municipality: this.municipality.id,
                            address: this.customer.address,
                            mobile: this.customer.mobile,
                            fax: this.customer.fax,
                            tel: this.customer.tel
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
                }else{
                    axios.put(this.currentUrl + '/request/cro/customer/store', {
                        id: this.customer.id,
                        name: this.customer.name,
                        bussiness: this.bussiness.id,
                        type: this.type.id,
                        industry: this.industry.id,
                        classification: this.classification.id,
                        region: this.agencyid,
                        province: this.province.id,
                        municipality: this.municipality.id,
                        address: this.customer.address,
                        email: this.customer.email,
                        user_id: this.customer.user_id,
                        mobile: this.customer.mobile,
                        fax: this.customer.fax,
                        tel: this.customer.tel
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

            view(selectedcustomer){
                (this.selectedcustomer.id != null) ? this.edit = true : this.edit = false;
                this.customer.id = this.selectedcustomer.id;
                this.customer.user_id = this.selectedcustomer.user_id;
                this.customer.name = this.selectedcustomer.name;
                this.customer.bussiness = this.selectedcustomer.bussiness;
                this.customer.type = this.selectedcustomer.type;
                this.customer.industry = this.selectedcustomer.industry;
                this.customer.classification = this.selectedcustomer.classification;
                this.customer.province = this.selectedcustomer.province;
                this.customer.municipality = this.selectedcustomer.municipality;
                this.customer.address = this.selectedcustomer.address;
                this.customer.email = this.selectedcustomer.email;
                this.customer.mobile = this.selectedcustomer.mobile;
                this.customer.fax = this.selectedcustomer.fax;
                this.customer.tel = this.selectedcustomer.tel;
            },

            close(){
                this.edit = false;
                this.errors = [];
                this.viewnew = false;
            },

        clearerrors(){
            this.errors = [];
        },

        addTag(){
            
        },

        onChangeCustomer(custom){
            this.viewnew = true;
            this.newcustomer = true;
        },

        customercheck(status){
            if(status == true) {
                this.viewnew = true;
                this.custom = '';
                this.newcustomer == true;
            }else{
                this.viewnew = true;
                this.newcustomer == false;
            }
        }
    },
    components: { Multiselect }
}
</script>