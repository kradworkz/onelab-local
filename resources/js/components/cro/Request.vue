

<template>

    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">

                <div class="card filemanager-sidebar mr-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                               <button type="button" class="btn btn-danger btn-block waves-effect waves-light" @click="addnew">New Request</button>
                                <!-- <h6 class="mt-3">In House</h6> -->
                                <div class="mail-list mt-4">
                                    <a v-for="dd in dropdownlists" v-bind:key="dd.id" @click="pick(dd.id)" :class="{active:selected == dd.id}"><i class="mdi mdi-adjust mr-2"></i> {{dd.name}} </a>
                                    <a @click="pick(0)" :class="{active:selected == 0}"><i class="mdi mdi-adjust mr-2"></i> Referrer </a>
                                </div>
                               
                                    
                                    <div class="mt-4">
                                        <div class="card border shadow-none mb-2">
                                            <a href="javascript: void(0);" class="text-body">
                                                <div class="p-2">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs align-self-center mr-2">
                                                            <div class="avatar-title rounded bg-transparent text-success font-size-20">
                                                                <i class="mdi mdi-image"></i>
                                                            </div>
                                                        </div>
    
                                                        <div class="overflow-hidden mr-auto">
                                                            <h5 class="font-size-13 text-truncate mb-1">Images</h5>
                                                            <p class="text-muted text-truncate mb-0">176 Files</p>
                                                        </div>
    
                                                        <div class="ml-2">
                                                            <p class="text-muted">6 GB</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>

                                        <div class="card border shadow-none mb-2">
                                            <a href="javascript: void(0);" class="text-body">
                                                <div class="p-2">
                                                    <div class="d-flex">
                                                        <div class="avatar-xs align-self-center mr-2">
                                                            <div class="avatar-title rounded bg-transparent text-danger font-size-20">
                                                                <i class="mdi mdi-play-circle-outline"></i>
                                                            </div>
                                                        </div>

                                                        <div class="overflow-hidden mr-auto">
                                                            <h5 class="font-size-13 text-truncate mb-1">Video</h5>
                                                            <p class="text-muted text-truncate mb-0">45 Files</p>
                                                        </div>

                                                        <div class="ml-2">
                                                            <p class="text-muted">4.1 GB</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                               
                            </div>
                        </div>
                    </div>
                </div>

                 <div class="w-100">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-3">
                                    <multiselect 
                                    v-model="from" 
                                    :options="dropdownlists2"
                                    label="name" track-by="id"
                                    :allow-empty="false"
                                    @input="onChange(from)"
                                    deselect-label="Can't remove this value">
                                    </multiselect>
                                </div>
                                <div class="col-sm-5"></div>
                                <div class="col-sm-4">
                                    <div class="search-box mb-2 mr-2">
                                        <div class="position-relative">
                                            <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch">
                                            <i class="bx bx-search-alt search-icon"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap tablecenter">
                                    <thead>
                                        <tr>
                                            <th>Reference</th>
                                            <th class="text-center">Customer</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Due Date</th>
                                            <th class="text-center">Requested Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="request in requests" v-bind:key="request.id">
                                            <td>{{request.reference}}</td>
                                            <td class="text-center">{{request.customer}}</td>
                                            <td class="text-center">
                                                <span v-if="request.status == 'Pending'" class="badge badge-lg badge-warning">Pending</span>
                                                <span v-else-if="request.status == 'Completed'" class="badge badge-lg badge-success">Completed</span>
                                                <span v-else-if="request.status == 'Confirmed'" class="badge badge-lg badge-info">Confirmed</span>
                                                <span v-else-if="request.status == 'Ongoing'" class="badge badge-lg badge-primary">Ongoing</span>
                                                <span v-else-if="request.status == 'Cancelled'" class="badge badge-lg badge-danger">Cancelled</span>
                                                <span v-else class="badge badge-dark">Waiting</span>
                                            </td>
                                            <td class="text-center">{{request.due_at}}</td>
                                            <td class="text-center">{{request.updated_at}}</td>
                                            <td class="text-center">
                                                <a :href="'request/'+request.id" target="_blank" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="View"><i class="bx bxs-show font-size-18"></i></a>
                                                <a href="javascript:void(0);" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="bx bxs-edit-alt font-size-18"></i></a>
                                                <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="bx bxs-trash font-size-18"></i></a>
                                            </td>
                                        </tr>
                                         <!-- <tr v-bind:class="[customer.sync == 'Synced' ? 'table-success' : '']" v-for="customer in customers" v-bind:key="customer.id">
                                            <td>
                                                <div class="avatar-xs">
                                                    <span class="avatar-title rounded-circle">{{customer.name.charAt(0)}}</span>
                                                </div>
                                            </td>
                                            <td class="text-center">{{customer.name}}</td>
                                            <td class="text-center">{{customer.address}}</td>
                                            <td class="text-center">
                                                <span v-if="customer.status == 0" class="badge badge-lg badge-success">Active</span>
                                                <span v-else class="badge badge-danger">Inactive</span>
                                            </td>
                                            <td class="text-center" style="font-size: 12px;">{{customer.created_at}}</td>
                                            <td class="text-center">
                                               <button type="button" class="btn btn-primary btn-sm btn-rounded">View Details </button>
                                            </td>
                                            <td class="text-center">
                                                <a href="javascript:void(0);" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="mdi mdi-pencil font-size-18"></i></a>
                                                <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="mdi mdi-close font-size-18"></i></a>
                                            </td>
                                        </tr> -->
                                    </tbody>
                                </table>
                            </div>

                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-center my-3">
                                    <li class="page-item"><a class="page-link" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)" href="#">Previous</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                                    <li class="page-item"><a class="page-link" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)" href="#">Next</a></li>
                                </ul>
                            </nav>

                        </div>
                    </div>
                 </div>

                <div class="modal fade exampleModal" id="new" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <request-create :agncy="agency" :selectedrequest="selectrequest" :typeid="type" @status="newrequest" ref="addrequest"> </request-create>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    import Multiselect from 'vue-multiselect';
    export default {
        props: ['agency'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                keyword: '',
                requests : [], 
                dropdownlists: [],
                dropdownlists2: [],
                selectrequest: {},
                referrers: [],
                edit: false,
                type: '',
                from: '',
                selected : 1
            }
        },

        created(){
            this.getDDList2();
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

            getDDList() {
                axios.get('/request/admin/dd/active/Request Type')
                .then(response => {
                    this.dropdownlists = response.data.data;
                    this.type = this.dropdownlists[0].id;
                    this.pick(this.type);
                })
                .catch(err => console.log(err));
            },

            getDDList2(page_url) {
                axios.get('/request/admin/dd/active/Request From')
                .then(response => {
                    this.dropdownlists2 = response.data.data;
                    this.from = this.dropdownlists2[0];
                    this.getDDList();
                })
                .catch(err => console.log(err));
            },

            pick(number){
                this.selected = number;
                this.type = number;
                if(number != 0){
                    this.fetch()
                }else{
                    this.$parent.validateToken();
                    this.requests = [];
                } 
                
            },

            fetch(page_url) {
                let vm = this;
                axios.post(this.currentUrl + '/request/cro/request/search', {
                    word: this.keyword,
                    type: this.type,
                    from: this.from.id
                })
                .then(response => {
                    this.requests = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            addnew(){
                this.selectrequest = {};
                this.$refs.addrequest.checkType(this.type);
                $("#new").modal("show");
            },

            newrequest(status) {
                if (status) {
                    $("#new").modal("hide");
                    this.fetch();
                    if (this.edit == true) {
                        Vue.$toast.success('<strong>Successfully Updated</strong>', {
                            position: 'bottom-left'
                        });
                    } else {
                        Vue.$toast.success('<strong>Successfully Created</strong>', {
                            position: 'bottom-left'
                        });
                    }
                }
                this.edit = false;
            },

            onChange(from){
                this.from = from;
                this.fetch();
            },

            check(value){
                if(value == true){
                    let toks = localStorage.getItem('api_token');

                    axios.get('https://one.main/api/requests/11',{
                        headers: {
                            'Content-Type': 'application/json',
                            'Authorization' : `Bearer ${toks}`
                        }
                    })
                    .then(response => {
                        this.requests = response.data.data;
                    })
                    .catch(err => console.log(err));
                }
            }

        }, components: { Multiselect }
    }
</script>


