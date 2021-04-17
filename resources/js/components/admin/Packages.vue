<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">

                <div class="w-100">
                    <div class="card">
                        <div class="card-body">

                            <div>
                                <div class="row mb-3">
                                    <div class="col-xl-3 col-sm-6">
                                        <multiselect @input="onChangeLab(laboratory.id)" 
                                            v-model="laboratory"
                                            :options="laboratories" 
                                            placeholder="Laboratory" 
                                            :allow-empty="false"
                                            deselect-label="Can't remove this value"
                                            label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                    <div class="col-xl-3 col-sm-6">
                                       <multiselect    
                                            @input="onChangeSample(sampletype.id)" 
                                            v-model="sampletype" 
                                            :options="sampletypes" 
                                            placeholder="Sampletype"
                                            :allow-empty="false"
                                            deselect-label="Can't remove this value"
                                            label="name" track-by="id">
                                        </multiselect>
                                    </div>
                                    <div class="col-xl-6 col-sm-6">
                                        <form class="mt-4 mt-sm-0 float-sm-right form-inline">
                                            <div class="mb-2 mr-2" v-if="syncable.length > 0">
                                                <div class="spinner-grow text-danger m-1" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="mb-2 mr-2">
                                                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" @click="sync">
                                                    <i class="mdi mdi-download font-size-16 align-middle mr-2"></i> Sync from Central Server
                                                </button>
                                            </div>
                                            <div class="search-box mb-2 mr-2">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="search">
                                                    <i class="bx bx-search-alt search-icon"></i>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Fee</th>
                                            <th class="text-center">Created at</th>
                                            <th class="text-center">Updated at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="p in packages" v-bind:key="p.id">
                                            <td class="text-center">{{p.name}}</td>
                                            <td class="text-center">{{p.fee}}</td>
                                            <td class="text-center">{{p.created_at}}</td>
                                            <td class="text-center">{{p.updated_at}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                 <ul class="pagination justify-content-end mb-2">
                                    <li class="page-item"><a style="cursor: pointer;" class="page-link" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                                    <li class="page-item"><a style="cursor: pointer;" class="page-link" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="modal fade exampleModal" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Sync from Central Server</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="p-2">
                                    <h5 class="text-primary">List of available to sync: {{syncable.length}}</h5><br>
                                    <div data-simplebar style="max-height: 150px;">
                                        <div class="text-muted" v-if="syncable.length > 0">
                                            <p class="mb-1" v-for="sync in syncable" v-bind:key="sync.id"><i class="mdi mdi-circle-medium align-middle text-primary mr-1"></i> {{sync.sampletype}}</p>
                                        </div>
                                        <div v-else class="alert alert-warning alert-dismissible fade show" role="alert">
                                            <i class="mdi mdi-alert-outline mr-2"></i> Nothing to sync.
                                        </div>
                                    </div>
                                
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button :disabled="syncable.length == 0" @click="create" type="button" class="btn btn-primary">Sync Now</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>


<script>
    import Multiselect from 'vue-multiselect'
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                packages : [],
                packagelists: [],
                packageSync: [],
                laboratories : [],
                sampletypes: [],
                testservices: [],
                syncable: [],
                pckage: {
                    id: '',
                    name: '',
                },
                laboratory: '',
                sampletype: '',
                keyword: ''
            }
        },

        created(){
            this.fetchList();
            this.syncPackage();
            this.fetchLaboratory();
        },

        methods : {
            makePagination(meta, links) {
                let pagination = {
                    current_page: meta.current_page,
                    last_page: meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                this.pagination = pagination;
            },

            fetch(page_url) {
                let vm = this;
                page_url = page_url || this.currentUrl + '/request/admin/packages/'+this.sampletype.id;

                axios.get(page_url)
                .then(response => {
                    this.packages = response.data.data;;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            fetchLaboratory() {
                axios.get('/request/admin/dd/active/Laboratory')
                .then(response => {
                    this.laboratories = response.data.data;
                    this.laboratory = this.laboratories[0]
                    this.fetchSampletype(this.laboratory.id);
                })
                .catch(err => console.log(err));
            },

            onChangeLab($id) {
                this.sampletype = '';
                this.packages = [];
                this.fetchSampletype($id);
            },

            fetchSampletype($id) {
                axios.get(this.currentUrl + '/request/admin/sampletypes/' + $id)
                .then(response => {
                    this.sampletypes = response.data.data;
                    if(this.sampletypes.length != 0){
                        this.sampletype = this.sampletypes[0];
                        this.fetch();
                    }
                })
                .catch(err => console.log(err));
            },

            onChangeSample() {
                this.fetch();
            },

            fetchList(page_url) {
                axios.get('/request/admin/package/list')
                .then(response => {
                    this.packagelists = response.data.data;
                })
                .catch(err => console.log(err));
            },

            syncPackage(page_url) 
            {
                axios.get('https://one.main/api/sync/packages')
                .then(response => {
                    this.packageSync = response.data.data;
                    
                    for(var i=0; i < this.packageSync.length; i++){
                        if(this.packagelists.length > 0){
                           
                            let x = this.packagelists.some(
                                pckage => (
                                    pckage.id === this.packageSync[i].id
                                )
                            )
                            if(!x){
                                this.syncable.push(this.packageSync[i]);
                            }
                        }else{
                            this.syncable.push(this.packageSync[i]);
                        }
                    } 
                    //console.log(this.syncable);
                })
                .catch(err => console.log(err));
            },

            sync() {
                this.syncable = [];
                this.syncPackage();
                $("#new").modal("show");
            },

            create(){
                 axios.post(this.currentUrl + '/request/admin/package/store', {
                    datas: this.syncable
                })
                .then(response => {
                    this.fetchLaboratory();
                    this.fetchList();
                    $("#new").modal("hide");
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            search() {
                let vm = this;
                axios.post(this.currentUrl + '/request/admin/packages/search', {
                    keyword: this.keyword,
                    sampletype: this.sampletype.id
                })
                .then(response => {
                    this.packages = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },
        
        },

        components: { Multiselect }
    }
</script>

