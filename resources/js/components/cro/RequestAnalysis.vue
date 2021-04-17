<template>
    <div>
       <div v-if="analyses.length > 0 || packages.length > 0">
            <hr>
            <h4 class="card-title text-info mb-4">My Analysis</h4>
            <div class="table-responsive">
                <table class="table table-centered table-nowrap table-hover mb-0">
                    <thead>
                        <tr>
                            <th scope="col">Code</th>
                            <th class="text-center" scope="col">Testname</th>
                            <th class="text-center" scope="col">Method</th>
                            <th class="text-right" scope="col">Status</th>
                            <th class="text-center" scope="col">Fee</th>
                            <th class="text-center" scope="col">Action</th>
                        </tr>
                        </thead>
                    <tbody>
                        <tr v-for="pck in packages" v-bind:key="pck.id">
                            <td class="text-body font-weight-bold">{{pck.code}}</td>
                            <td class="text-center">{{pck.testname}}</td>
                            <td class="text-center">{{pck.method}}</td>
                            <td class="text-right">
                                <span v-if="pck.status == 'Pending'" class="badge badge-lg badge-warning">Pending</span>
                                <span v-else-if="pck.status == 'Completed'" class="badge badge-lg badge-success">Completed</span>
                                <span v-else class="badge badge-danger">Ongoing</span>
                            </td>
                            <td class="text-center">₱{{pck.fee}}</td>
                                <td class="text-center">
                                <div class="dropdown">
                                    <a class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li @click="viewanalysis(pck)"><a class="dropdown-item"><i class="mdi mdi-eye font-size-16 text-success mr-1"></i> View</a></li>
                                        <li v-if="status == 'Pending'" @click="destroyanalysis(pck.id)"><a class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger mr-1"></i> Delete</a></li>
                                    </ul>
                                </div>             
                            </td>
                        </tr>
                        <tr v-for="analysis in analyses" v-bind:key="analysis.id">
                            <td class="text-body font-weight-bold">{{analysis.code}}</td>
                            <td class="text-center">{{analysis.testname}}</td>
                            <td class="text-center">{{analysis.method}}</td>
                            <td class="text-right">
                                <span v-if="analysis.status == 'Pending'" class="badge badge-lg badge-warning">Pending</span>
                                <span v-else-if="analysis.status == 'Completed'" class="badge badge-lg badge-success">Completed</span>
                                <span v-else class="badge badge-danger">Ongoing</span>
                            </td>
                            <td class="text-center">₱{{analysis.fee}}</td>
                                <td class="text-center">
                                <div class="dropdown">
                                    <a class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-right">
                                        <li @click="viewanalysis(analysis)"><a class="dropdown-item"><i class="mdi mdi-eye font-size-16 text-success mr-1"></i> View</a></li>
                                        <li v-if="status == 'Pending'" @click="destroyanalysis(analysis.id)"><a class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger mr-1"></i> Delete</a></li>
                                    </ul>
                                </div>             
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-right">Sub Total</td>
                            <td class="text-center">₱{{ formatPrice(subtotal)}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="border-0 text-right">Discount</td>
                            <td class="border-0 text-center">₱{{ formatPrice(ds)}}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="border-0 text-right">
                                <strong>Total</strong></td>
                            <td class="border-0 text-center"><h4 class="m-0">₱{{ formatPrice(total)}}</h4></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade exampleModal" id="showanalysis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title mt-1" id="exampleModalLabel">View Analysis</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="col-md-12">

                           
                            <div class="p-2">
                                <h5 class="text-primary">{{analysis.testname}} 
                                    <span v-if="analysis.status == 'Pending'" class="badge badge-warning float-right"> {{analysis.status}} </span>
                                    <span v-else-if="analysis.status == 'Ongoing'" class="badge badge-info float-right"> {{analysis.status}} </span>
                                    <span v-else class="badge badge-success float-right"> {{analysis.status}} </span>
                                </h5>
                                <p>{{analysis.method}}</p>

                                <div  v-if="analysis.type == 0">
                                    <p v-for="a in analysis.lists" v-bind:key="a.id" class="mb-1">
                                        <i class="mdi mdi-circle-medium align-middle text-primary mr-1"></i> {{a.testname}} 
                                        <span class="text-muted text-truncate mb-0">({{a.method}})</span>
                                        <span v-if="a.status == 'Pending'" class="badge badge-warning float-right"> {{a.status}} </span>
                                        <span v-else-if="a.status == 'Ongoing'" class="badge badge-info float-right"> {{a.status}} </span>
                                        <span v-else class="badge badge-success float-right"> {{a.status}} </span>
                                    </p>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
import Multiselect from 'vue-multiselect';
export default {
    props: ['percentage','status','reqsid'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            analyses : [],
            packages: [],
            analysis : {},
            edit: false,
            totals : '',
            ds : '',
            subtotal :''
        }
    },

    created(){
        this.fetchAnalyses(this.reqsid);
        this.fetchPackages(this.reqsid);
    },

    computed: {
        total() {
            this.subtotal = this.analyses.reduce((acc, item) => parseInt(acc) + parseInt(item.fee2), 0);
            this.subtotal2 = this.packages.reduce((acc, item) => parseInt(acc) + parseInt(item.fee2), 0);
            this.ds = Math.round((this.percentage/100) * (this.subtotal+this.subtotal2));
            this.totals = (this.subtotal+this.subtotal2) - this.ds;
            return this.totals;
        }
    },

    methods : {
       
        formatPrice(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

        fetchAnalyses(id) {
            axios.get(this.currentUrl + '/request/cro/analyses/'+id)
            .then(response => {
                this.analyses = response.data.data;
                this.$emit('analysiscount', this.analyses.length);
            })
            .catch(err => console.log(err));
        },

        fetchPackages(id) {
            axios.get(this.currentUrl + '/request/cro/analyses/packages/'+id)
            .then(response => {
                this.packages = response.data.data;
                this.$emit('analysiscount', this.packages.length);
            })
            .catch(err => console.log(err));
        },

        destroyanalysis(id)
        {
            axios.post(this.currentUrl + '/request/cro/analysis/destroy', {
                id: id,
            })
            .then(response => {
                Vue.$toast.error('<strong>Analysis Deleted</strong>', {
                    position: 'bottom-right'
                });
                this.fetchAnalyses(this.reqsid);
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        viewanalysis(analysis){
            this.analysis = analysis;
            $("#showanalysis").modal('show');
        }

    },  components: { Multiselect }
}
</script>
