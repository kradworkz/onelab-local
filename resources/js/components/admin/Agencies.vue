<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">

                <div class="card filemanager-sidebar mr-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                                <div class="mb-3">
                                    <div class="dropdown">
                                        <button class="btn btn-light btn-block dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="mdi mdi-plus mr-1"></i> Create New
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="#"><i class="bx bx-folder mr-1"></i> Folder</a>
                                            <a class="dropdown-item" href="#"><i class="bx bx-file mr-1"></i> File</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="mail-list mt-4">
                                  
                                </div>
                                <hr class="mb-4">
                                <div class="mt-2">
                                    <a href="#" class="media">
                                        <div class="media-body chat-user-box">
                                            <p class="user-title m-0">Scott Median</p>
                                            <p class="text-muted">Hello</p>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="w-100">
                    <div class="card">
                        <div class="card-body">

                            <div>
                                <div class="row mb-3">
                                    <div class="col-xl-5 col-sm-6 form-inline">
                                        <multiselect 
                                        v-model="type" 
                                        @input="changeDrop"
                                        :options="options"
                                        :allow-empty="false"
                                        deselect-label="Can't remove this value"
                                        label="name"
                                        >
                                        </multiselect>
                                    </div>
                                    <div class="col-xl-7 col-sm-6">
                                        <form class="mt-4 mt-sm-0 float-sm-right form-inline">
                                            <div class="mb-2 mr-2" v-if="syncable.length > 0">
                                                <div class="spinner-grow text-danger m-1" role="status">
                                                    <span class="sr-only">Loading...</span>
                                                </div>
                                            </div>
                                            <div class="mb-2 mr-2">
                                                <button type="button" class="btn btn-sm btn-primary waves-effect waves-light" @click="viewsync">
                                                    <i class="mdi mdi-download font-size-16 align-middle mr-2"></i> Sync from Central Server
                                                </button>
                                            </div>
                                            <div class="search-box mb-2 mr-2">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="getAgencyPaginated">
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
                                            <th>Name</th>
                                            <th>Acronym</th>
                                            <th>Code</th>
                                            <th>Status</th>
                                            <th>Created at</th>
                                            <th>Updated at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="agency in agencies" v-bind:key="agency.id">
                                            <td>{{agency.name}}</td>
                                            <td>{{agency.acronym}}</td>
                                            <td>{{agency.code}}</td>
                                            <td>
                                                <span v-if="agency.status == 'Active'" class="badge badge-lg badge-success">Active</span>
                                                <span v-else class="badge badge-danger">Inactive</span>
                                            </td>
                                            <td style="font-size: 12px;">{{agency.created_at}}</td>
                                            <td style="font-size: 12px;">{{agency.updated_at}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-2">
                                    <li class="page-item"><a class="page-link" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="getAgencyPaginated(pagination.prev_page_url)" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                                    <li class="page-item"><a class="page-link" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="getAgencyPaginated(pagination.next_page_url)" href="#">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
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
                            <h5 class="text-primary">List of {{ type.name }} available to sync: {{syncable.length}}</h5><br>
                            <div data-simplebar style="max-height: 150px;">
                                <div class="text-muted" v-if="syncable.length > 0">
                                    <p class="mb-1" v-for="sync in syncable" v-bind:key="sync.id"><i class="mdi mdi-circle-medium align-middle text-primary mr-1"></i> {{sync.name}}</p>
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
</template>

<script>
    import Multiselect from 'vue-multiselect'
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                keyword: '',
                agencies : [],
                agencylists: [],
                agencySync : [],
                syncable: [],
                options: [],
                editable : false,
                type: '',
                selected: 1
            }
        },

        created(){
            this.getTypes();
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

            getTypes() {
                axios.get('/request/admin/dd/list/Agency Type')
                .then(response => {
                    this.options = response.data.data;
                    this.type = this.options[0];
                    this.getAgencyList();
                    this.syncAgency();
                    this.getAgencyPaginated();
                })
                .catch(err => console.log(err));
            },

            getAgencyPaginated(page_url) {
                let vm = this;
                page_url = page_url || this.currentUrl + '/request/admin/agency/paginated';

                axios.post(page_url,{
                    type : this.type
                })
                .then(response => {
                    this.agencies = response.data.data;;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            getAgencyList(page_url) {
                axios.get('/request/admin/agency/list/'+this.type.id)
                .then(response => {
                    this.agencylists = response.data.data;
                })
                .catch(err => console.log(err));
            },

            syncAgency() {
                axios.get('https://one.main/api/sync/agencies/'+this.type.id)
                .then(response => {
                    this.agencySync = response.data.data;

                    for (var i = 0; i < this.agencySync.length; i++) {
                        if (this.agencylists.length > 0) {
                            let x = this.agencylists.some(
                                discount => (
                                    discount.id === this.agencySync[i].id
                                )
                            )
                            if (!x) {
                                this.syncable.push(this.agencySync[i]);
                            }
                        } else {
                            this.syncable.push(this.agencySync[i]);
                        }
                    }
                    //console.log(this.syncable);
                })
                .catch(err => console.log(err));
            },
            
            viewsync(){
                this.syncable = [];
                this.syncAgency();
                $("#new").modal('show');
            },

            create() {
                axios.post(this.currentUrl + '/request/admin/agency/store', {
                    datas: this.syncable
                })
                .then(response => {
                    this.getAgencyPaginated();
                    this.syncable = [];
                    $("#new").modal("hide");
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            changeDrop(){
                this.syncable = [];
                this.getAgencyPaginated();
                this.getAgencyList();
                this.syncAgency();
                this.errors = [];
                this.lists = [];
            },

        },components: { Multiselect }
    }
</script>