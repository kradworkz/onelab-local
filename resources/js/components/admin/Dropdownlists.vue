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
                                    <a @click="change(1)" :class="{active:selected == 1}">
                                        <i class="mdi mdi-format-list-bulleted mr-2"></i> 
                                        Request 
                                    </a>
                                    <a @click="change(2)" :class="{active:selected == 2}">
                                        <i class="mdi mdi-account-details mr-2"></i>Customer
                                    </a>
                                    <a @click="change(3)" :class="{active:selected == 3}">
                                        <i class="mdi mdi-cash-register mr-2"></i>Finance
                                    </a>
                                    <a @click="change(4)" :class="{active:selected == 4}">
                                        <i class="mdi mdi-cash-multiple mr-2"></i>Billing
                                    </a>
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
                                    <div class="col-xl-3 col-sm-6 form-inline">
                                        <multiselect 
                                        v-model="type" 
                                        @input="changeDrop"
                                        :options="options"
                                        :allow-empty="false"
                                        deselect-label="Can't remove this value">
                                        </multiselect>
                                    </div>
                                    <div class="col-xl-9 col-sm-6">
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
                                                    <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="getDDPaginated">
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
                                            <th v-if="type == 'Agency Type' || type == 'Laboratory'">Code</th>
                                            <th v-if="type == 'Discount'">Percentage</th>
                                            <th>Status</th>
                                            <th>Created at</th>
                                            <th>Updated at</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="dropdownlist in dropdowns" v-bind:key="dropdownlist.id">
                                            <td>{{dropdownlist.name}}</td>
                                            <td v-if="dropdownlist.type == 'Agency Type' || dropdownlist.type == 'Laboratory'">{{dropdownlist.code}}</td>
                                            <td v-if="dropdownlist.type == 'Discount'">{{dropdownlist.percentage}}%</td>
                                            <!-- <td><span v-html="dropdownlist.status"></span></td> -->
                                            <td>
                                                <span v-if="dropdownlist.status == 0" class="badge badge-lg badge-success">Active</span>
                                                <span v-else class="badge badge-danger">Inactive</span>
                                            </td>
                                            <td style="font-size: 12px;">{{dropdownlist.created_at}}</td>
                                            <td style="font-size: 12px;">{{dropdownlist.updated_at}}</td>
                                            <td class="text-right">
                                                <button v-if="dropdownlist.status == 0" @click="status(dropdownlist.id,dropdownlist.status)" class="btn btn-sm btn-danger waves-effect waves-light">Deactivate</button>
                                                <button v-else @click="status(dropdownlist.id,dropdownlist.status)" class="btn btn-sm btn-success waves-effect waves-light">Activate</button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-2">
                                    <li class="page-item"><a style="cursor: pointer;" class="page-link" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="getDDPaginated(pagination.prev_page_url)">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                                    <li class="page-item"><a style="cursor: pointer;" class="page-link" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="getDDPaginated(pagination.next_page_url)">Next</a></li>
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
                            <h5 class="text-primary">List of {{ type }} available to sync: {{syncable.length}}</h5><br>
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
                dropdowns : [],
                dropdownlists: [],
                dropdownSync : [],
                syncable: [],
                request: ["Agency Type","Request Type","Request From","Laboratory","Purpose"],
                customer: ["Bussiness Nature","Industry Type","Customer Type","Classification"],
                finance: ["Collection Type","Deposit Type","OR Category"],
                billing: ["Mode of Release","Discount","Payment Mode"],
                options: ["Agency Type","Request Type","Request From","Laboratory","Purpose"],
                editable : false,
                type: 'Agency Type',
                selected: 1
            }
        },

        created(){
            this.getDDPaginated();
            this.getDDList();
            this.syncdropdowns();
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

            getDDPaginated(page_url) {
                let vm = this;
                page_url = page_url || this.currentUrl + '/request/admin/dd/paginated';

                axios.post(page_url,{
                    type : this.type
                })
                .then(response => {
                    this.dropdowns = response.data.data;;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            getDDList(page_url) {
                axios.get('/request/admin/dd/list/'+this.type)
                .then(response => {
                    this.dropdownlists = response.data.data;
                })
                .catch(err => console.log(err));
            },

            syncdropdowns() {
                axios.get('https://one.main/api/sync/dropdownlists/'+this.type)
                .then(response => {
                    this.dropdownSync = response.data.data;

                    for (var i = 0; i < this.dropdownSync.length; i++) {
                        if (this.dropdownlists.length > 0) {
                            let x = this.dropdownlists.some(
                                discount => (
                                    discount.id === this.dropdownSync[i].id
                                )
                            )
                            if (!x) {
                                this.syncable.push(this.dropdownSync[i]);
                            }
                        } else {
                            this.syncable.push(this.dropdownSync[i]);
                        }
                    }
                    //console.log(this.syncable);
                })
                .catch(err => console.log(err));
            },
            
            viewsync(){
                this.syncable = [];
                this.syncdropdowns();
                $("#new").modal('show');
            },

            create() {
                axios.post(this.currentUrl + '/request/admin/dd/store', {
                    datas: this.syncable
                })
                .then(response => {
                    this.getDDPaginated();
                    this.syncable = [];
                    $("#new").modal("hide");
                    Vue.$toast.success('<strong>Sync Successfully</strong>', {
                        position: 'bottom-left'
                    });
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            },

            status(id,status){
                axios.post(this.currentUrl + '/request/admin/dd/status', {
                   id : id,
                   status: status
                })
                .then(response => {
                    let page_url = '/request/admin/dd/paginated?page=' + this.pagination.current_page;
                    this.getDDPaginated(page_url);
                })
                .catch(err => console.log(err));
            },

            changeDrop(){
                this.syncable = [];
                this.getDDPaginated();
                this.getDDList();
                this.syncdropdowns();
                this.errors = [];
                this.lists = [];
            },

            change(number){
                this.selected = number;
                if(number == 1){
                    this.options = this.request;
                    this.type = this.request[0];
                }else if(number == 2){
                    this.options = this.customer;
                    this.type = this.customer[0];
                }else if(number == 3){
                    this.options = this.finance;
                    this.type = this.finance[0];
                }else{
                    this.options = this.billing;
                    this.type = this.billing[0];
                }
                this.changeDrop();
            }
        
        },

        components: { Multiselect }
    }
</script>