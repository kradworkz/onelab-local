<template>
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-1" id="exampleModalLabel">Add Analysis</h5>
                <div class="btn-group btn-group-example" role="group">
                    <button type="button" class="btn btn-outline-primary w-sm" @click="type(smpltype,'Solo')">Solo</button>
                    <button type="button" class="btn btn-outline-primary w-sm" @click="type(smpltype,'Package')">Package</button>
                </div>
            </div>
            
            <form @submit.prevent="createanalysis">
                <div class="modal-body">
                    <div class="col-md-12" style="margin-top: 15px;">
                    
                        <div v-if="list == 'Solo'">
                            <div v-if="requesttype != 'Referral'">
                                <div class="row customerform">
                                    <div class="col-md-12">
                                        <div class="form-group form-primary">
                                            <label class="float-label" v-bind:style="errors.testservice ? 'color: red' : ''">Testname</label>
                                            <multiselect  v-model="testservice" :options="testservices" placeholder="Select Testname" :disabled="edit" label="testname" track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                </div>

                                <div class="alert alert-info mb-0" role="alert" v-if="testservice != ''">
                                    <h5>{{testservice.method}}</h5><h6 class="float-right" style="margin-top: -20px;">₱{{testservice.fee}}</h6>
                                    <span class="text-muted mb-0">{{testservice.reference}}</span>
                                </div>
                            </div>
                            <div v-else>
                                 <div class="search-box mb-4">
                                    <div class="position-relative">
                                        <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="search(smpltype,requesttype)">
                                        <i class="bx bx-search-alt search-icon"></i>
                                    </div>
                                </div>
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th v-if="edit == false">#</th>
                                            <th>Agency</th>
                                            <th>Testname</th>
                                            <th>Method</th>
                                            <th>Reference</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="test in testservices" v-bind:key="'a-'+test.id">
                                            <td v-if="edit == false">
                                                <div class="custom-control custom-radio">
                                                    <input type="radio" :id="'customCheck_'+ test.id" :value="test" v-model="selected" class="custom-control-input">
                                                    <label class="custom-control-label" :for="'customCheck_' + test.id">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>{{test.agency}}</td>
                                            <td>{{test.testname}}</td>
                                            <td>{{test.method}}</td>
                                            <td>{{test.reference}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div v-else>
                            <div v-if="requesttype != 'Referral'">
                                <div class="row customerform">
                                    <div class="col-md-12">
                                        <div class="form-group form-primary">
                                            <label class="float-label" v-bind:style="errors.packge ? 'color: red' : ''">Package Name</label>
                                            <multiselect :custom-label="nameWithLang" v-model="testservice" :options="packages" placeholder="Select Package" :disabled="edit" label="name" track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive" data-simplebar style="max-height: 250px;">
                                    <table class="table table-centered table-nowrap">
                                        <tbody>
                                            <tr  v-for="list in testservice.lists" v-bind:key="list.id">
                                                <td>
                                                    <h5 class="font-size-12 mb-1"><a href="#" class="text-dark">{{list.method}}</a></h5>
                                                    <p class="text-muted mb-0">{{list.reference}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div v-else>
                                <div v-if="viewpack == false">
                                    <table class="table table-centered table-nowrap">
                                        <thead>
                                            <tr>
                                                <th v-if="edit == false">#</th>
                                                <th>Agency</th>
                                                <th>Package Name</th>
                                                <th>Fee</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="test in packages" v-bind:key="'a-'+test.id">
                                                <td v-if="edit == false">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" :id="'customCheck_'+ test.id" :value="test" v-model="selected" class="custom-control-input">
                                                        <label class="custom-control-label" :for="'customCheck_' + test.id">&nbsp;</label>
                                                    </div>
                                                </td>
                                                <td>{{test.agency}}</td>
                                                <td>{{test.name}}</td>
                                                <td>{{test.fee}}</td>
                                                <th><button type="button" class="btn btn-sm btn-primary waves-effect waves-light active" @click="viewpackage(test.lists)">View</button></th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div v-else>
                                    <div class="table-responsive" data-simplebar style="max-height: 250px;">
                                        <table class="table table-centered table-nowrap">
                                            <tbody>
                                                <tr  v-for="list in lists" v-bind:key="list.id">
                                                    <td>
                                                        <h5 class="font-size-12 mb-1"><a href="#" class="text-dark">{{list.method}}</a></h5>
                                                        <p class="text-muted mb-0">{{list.reference}}</p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                  

                    </div>
                </div>
                <div class="modal-footer" v-if="viewpack == false">
                    <button type="submit" class="btn btn-primary">Save</button>
                    <button type="button" @click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
                <div class="modal-footer" v-else>
                    <button type="button" @click="viewpack = false" class="btn btn-secondary" data-dismiss="modal">Back</button>
                </div>
            </form>

        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
export default {
    props: ['requesttype','smpl','smpltype', 'status'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            keyword: '',
            testservices : [],
            packages : [],
            packge : '',
            testservice : '',
            lists : [],
            list: 'Solo',
            edit: false,
            selected : '',
            viewpack: false
        }
    },

    // computed: {
    //     test() {
    //         this.type(this.smpltype,this.list);
    //     }
    // },

    methods : {
        nameWithLang ({ name, fee }) {
            return `${name} - ₱${fee}`;
        },

        type(id,type){
            this.testservice = '';
            this.packge = '';
            this.selected = '';
            this.list = type;
            (this.list == 'Solo') ? this.fetchSolo(id,this.requesttype) : this.fetchPackage(id,this.requesttype);
        },
    
        fetchSolo(id,type){
            axios.get(this.currentUrl + '/request/cro/solo/'+id+'/'+type)
            .then(response => {
                this.testservices = response.data.data;
            })
            .catch(err => console.log(err));
        },

        fetchPackage(id,type){
            axios.get(this.currentUrl + '/request/cro/packages/'+id+'/'+type)
            .then(response => {
                this.packages = response.data.data;
            })
            .catch(err => console.log(err));
        },

        createanalysis()
        {
            axios.post(this.currentUrl + '/request/cro/analysis/store', {
                sample_id: this.smpl,
                method_id: (this.requesttype != 'Referral') ? this.testservice.id : this.selected.id,
                fee: (this.requesttype != 'Referral') ? this.testservice.fee : this.selected.fee,
                type: this.list,
                requesttype: this.requesttype
            })
            .then(response => {
                $("#newanalysis").modal('hide');
                this.clear();
                Vue.$toast.success('<strong>Analysis Added!</strong>', {
                    position: 'bottom-right'
                });
                this.$emit('done', true);
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        clear(){

        },

        search(id,type){
            if(this.keyword.length > 1){
                axios.get(this.currentUrl + '/request/cro/solo/'+id+'/'+type+'/'+this.keyword)
                .then(response => {
                    this.testservices = response.data.data;
                })
                .catch(err => console.log(err));
            }
        },

        viewpackage(data){
            this.lists = data;
            this.viewpack = true;
        }

    },  components: { Multiselect }
}
</script>
