<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">

                <div class="card filemanager-sidebar mr-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                               <button type="button" class="btn btn-danger btn-block waves-effect waves-light" @click="addnew">New Customer</button>
                                <div class="mail-list mt-4">
                                    <a href="#" class="active"><i class="mdi mdi-lock-open-check mr-2"></i> Active <span class="ml-1 float-right">(18)</span></a>
                                    <a href="#"><i class="mdi mdi-lock-clock mr-2"></i>Inactive</a>
                                    <a href="#"><i class="mdi mdi-lock-alert mr-2"></i>Disabled</a>
                                    <a href="#"><i class="mdi mdi-lock-outline mr-2"></i>Retired</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-100">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-8">
                                   
                                </div>
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
                                        <tr><th></th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Created at</th>
                                            <th class="text-center">Info</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <tr v-bind:class="[customer.sync == 'Synced' ? 'table-success' : '']" v-for="customer in customers" v-bind:key="customer.id">
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
                                                <a href="javascript:void(0);" class="mr-3 text-primary" data-toggle="tooltip" data-placement="top" title="" data-original-title="Edit"><i class="bx bxs-show font-size-18"></i></a>
                                                <a href="javascript:void(0);" class="text-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="Delete"><i class="bx bxs-edit-alt font-size-18"></i></a>
                                            </td>
                                        </tr>
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
                    <customer-create :agencyid="agency" :selectedcustomer="selectcustomer" @status="newcustomer"></customer-create>
                </div>

            </div>
        </div>
    </div>
</template>


<script>
    export default {
        props: ['agency'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                keyword: '',
                customers : [], 
                selectcustomer: {},
                edit: false
            }
        },

        created(){
            this.fetch();
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
                axios.post(this.currentUrl + '/request/cro/customer/search', {
                    word: this.keyword,
                })
                .then(response => {
                    this.customers = response.data.data;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },

            addnew(){
                this.selectcustomer = {};
                $("#new").modal("show");
            },

            newcustomer(status) {
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

        }
    }
</script>