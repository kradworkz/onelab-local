<template>
    <div>
        <div class="float-right">
            <button v-if="status == 'Pending'" @click="addsample" class="btn btn-primary waves-effect waves-light btn-sm"> + Add Sample</button>
        </div>
        <h4 class="card-title text-info mb-4">My Samples</h4>

        <div class="table-responsive">
            <table class="table table-centered table-nowrap table-hover mb-5">
                <thead>
                    <tr>
                        <th scope="col">Code</th>
                        <th class="text-center" scope="col">Samplename</th>
                        <th class="text-center" scope="col">Sampletype</th>
                        <th class="text-center" scope="col">Received At</th>
                        <th class="text-center" scope="col" v-if="status == 'Pending'"></th> 
                        <th class="text-center" scope="col">Action</th>
                    </tr>
                    </thead>
                <tbody>
                    <tr v-for="sample in samples" v-bind:key="sample.id">
                        <td class="text-body font-weight-bold">{{sample.code}}</td>
                        <td class="text-center">{{sample.name}}</td>
                        <td class="text-center">{{sample.sampletype.name}}</td>
                        <td class="text-center">
                            {{sample.created_at}}
                        </td>
                        <td class="text-center" v-if="status == 'Pending'">
                            <a class="btn btn-danger btn-sm w-xs" @click="addanalysis(sample.id,sample.sampletype.id)">Add Analysis</a>
                        </td>
                        <td class="text-center">
                            <div class="dropdown">
                                <a class="dropdown-toggle card-drop" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal font-size-18"></i>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-right">
                                    <li @click="viewsample(sample)"><a class="dropdown-item"><i class="mdi mdi-eye font-size-16 text-success mr-1"></i> View</a></li>
                                    <li v-if="status == 'Pending'" @click="editsample(sample)"><a class="dropdown-item"><i class="mdi mdi-pencil font-size-16 text-success mr-1"></i> Edit</a></li>
                                    <li v-if="status == 'Pending'" @click="destroysample(sample.id)"><a class="dropdown-item"><i class="mdi mdi-trash-can font-size-16 text-danger mr-1"></i> Delete</a></li>
                                </ul>
                            </div>             
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal fade exampleModal" id="newsample" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Add Sample</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="clear">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <form @submit.prevent="createsample">
                        <div class="modal-body">
                            <div class="col-md-12" style="margin-top: 15px;">

                                <div class="row customerform">
                                    <div class="col-md-12">
                                        <div class="form-group form-primary">
                                            <label class="float-label" v-bind:style="errors.sampletype ? 'color: red' : ''">Sampletype</label>
                                            <multiselect 
                                            v-model="sampletype" 
                                            :options="sampletypes" 
                                            placeholder="Select Sampletype"
                                            :disabled="edit" 
                                            :allow-empty="false"
                                            deselect-label="Can't remove"
                                            :searchable="true"
                                            @search-change="asyncFind"
                                            id="ajax"
                                            label="name" track-by="id">
                                            </multiselect>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="float-label">Samplename <code style="color: red;" v-if="errors.name">({{ errors.name[0] }})</code></label>
                                            <input placeholder="Enter Samplename" type="text" v-model="name" class="form-control" style="text-transform:capitalize;">
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="row customerform">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="float-label">Description <code style="color: red;" v-if="errors.desc">({{ errors.name[0] }})</code></label>
                                            <textarea required="" v-model="desc" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="float-label">Customer Description<code style="color: red;" v-if="errors.customer_desc">({{ errors.name[0] }})</code></label>
                                            <textarea required="" v-model="customer_desc" class="form-control" rows="3"></textarea>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" @click="clear" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        
        <div class="modal fade exampleModal" id="newanalysis" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <request-new-analysis :requesttype="type" :smpl="sample_id" :smpltype="sampletype_id" :status="status" @done="finished" ref="addnewanalysis"></request-new-analysis> 
        </div>

         <div class="modal fade exampleModal" id="viewsample" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">View Sample</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="col-md-12">

                            
                            <div class="media">   
                                <div class="media-body">
                                    <h5 class="font-size-12">Code :</h5>
                                    <p class="text-muted">{{ sample.code }}</p>
                                </div> 
                                <div class="media-body">
                                    <h5 class="font-size-12">Sampletype :</h5>
                                    <p class="text-muted">{{ sample.sampletypename }}</p>
                                </div> 
                            </div>
                             <div class="media">  
                                <div class="media-body">
                                    <h5 class="font-size-12">Customer Description :</h5>
                                    <p class="text-muted">{{ sample.customer_desc }}</p>
                                </div>   
                                <div class="media-body">
                                    <h5 class="font-size-12">Description :</h5>
                                    <p class="text-muted">{{ sample.desc }}</p>
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
    props: ['agencyid','lab','status','reqsid','type'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            samples : [],
            sample : {},
            sampletypes : [],
            sampletype: '',
            sampletype_id: '',
            id: '',
            name: '',
            desc: '',
            customer_desc: '',
            keyword: '',
            edit: false,
            sample_id: '',
        }
    },

    created(){
        this.fetchSamples(this.reqsid);
    },


    methods : {

        asyncFind(value) {
            if(value.length > 4){
                if(this.type != 'Referral'){
                    axios.post(this.currentUrl + '/request/cro/sampletypes', {
                        word: value,
                        laboratory: this.lab,
                        type: this.type
                    })
                    .then(response => {
                        this.sampletypes = response.data.data;
                    })
                    .catch(err => console.log(err));
                }else{
                    axios.post(this.currentUrl + '/request/cro/sampletypes', {
                        word: value,
                        laboratory: this.lab,
                        type: this.type
                    })
                    .then(response => {
                        this.sampletypes = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            }
        },

       
        // fetchSampletypes(id) {
        //     axios.get(this.currentUrl + '/request/cro/sampletypes/'+id)
        //     .then(response => {
        //         this.sampletypes = response.data.data;
        //     })
        //     .catch(err => console.log(err));
        // },

        // fetchReferralSampletypes(id) {
        //     axios.get(this.currentUrl + '/request/cro/sampletypes/'+id)
        //     .then(response => {
        //         this.sampletypes = response.data.data;
        //     })
        //     .catch(err => console.log(err));
        // },

        fetchSamples(id) {
            axios.get(this.currentUrl + '/request/cro/samples/'+id)
            .then(response => {
                this.samples = response.data.data;
            })
            .catch(err => console.log(err));
        },

        addsample(){
                
            // (this.type == 'Referral') ? this.fetchReferralSampletypes(this.lab) : this.asyncFind(this.lab);
            $("#newsample").modal('show');
        },

        createsample()
        {
            axios.post(this.currentUrl + '/request/cro/sample/store', {
                id: this.id,
                name: this.name,
                desc : this.desc,
                customer_desc: this.customer_desc,
                sampletype : this.sampletype.id,
                request : this.reqsid,
                edit : this.edit
            })
            .then(response => {
                $("#newsample").modal('hide');
                this.clear();
                Vue.$toast.success('<strong>Sample Saved</strong>', {
                    position: 'bottom-right'
                });
                this.fetchSamples(this.reqsid);
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        editsample(sample){
            this.edit = true;
            this.id = sample.id;
            this.name = sample.name;
            this.desc = sample.desc;
            this.customer_desc = sample.customer_desc;
            this.sampletype = sample.sampletype;
            $("#newsample").modal('show');
        },

        destroysample(id)
        {
            axios.post(this.currentUrl + '/request/cro/sample/destroy', {
                id: id,
            })
            .then(response => {
                Vue.$toast.error('<strong>Sample Deleted</strong>', {
                    position: 'bottom-right'
                });
                this.fetchSamples(this.reqsid);
            })
            .catch(error => {
                if (error.response.status == 422) {
                    this.errors = error.response.data.errors;
                }
            });
        },

        clear(){
            this.edit = false;
            this.id = '';
            this.name = '';
            this.desc = '';
            this.customer_desc = '';
            this.sampletype = '';
            this.testservice = '';
        },

        addanalysis(id,sampletype_id)
        {
            this.sample_id = id;
            this.sampletype_id = sampletype_id;
            $("#newanalysis").modal('show');
            // (this.type == 'Referral') ? this.$refs.addnewanalysis.fetchSoloReferral(sampletype_id) : this.$refs.addnewanalysis.fetchSolo(sampletype_id);
            this.$refs.addnewanalysis.fetchSolo(sampletype_id,this.type);
        },

        finished(status) {
            this.$emit('done', true);
        },

        viewsample(sample){
            this.sample = sample;
            $("#viewsample").modal('show');
        }

    },  components: { Multiselect }
}
</script>
