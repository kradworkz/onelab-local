
<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">
                
                <div class="card filemanager-sidebar mr-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                                <button class="btn btn-danger btn-block" type="button" @click="addnew">
                                    New OR Series
                                </button>
                               
                                <div class="mail-list mt-4">
                                    <a  v-for="dd in dropdownlists" v-bind:key="dd.id" @click="pick(dd.id)" :class="{active:selected == dd.id}"><i class="mdi mdi-adjust mr-2"></i> {{dd.name}} </a>
                                </div>

                                <h6 class="mt-4">Labels</h6>

                                <div class="mail-list mt-1">
                                    <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-info float-right"></span>Active</a>
                                    <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-warning float-right"></span>Disabled</a>
                                    <a href="#"><span class="mdi mdi-arrow-right-drop-circle text-primary float-right"></span>Retired</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-100">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4">
                                   
                                </div>
                               <div class="col-xl-8 col-sm-6">
                                    <form class="mt-4 mt-sm-0 float-sm-right form-inline">
                                        <div class="search-box mb-2 mr-2">
                                            <div class="position-relative">
                                                <input type="text" class="form-control bg-light border-light rounded" placeholder="Search..." v-model="keyword" @keyup="fetch()">
                                                <i class="bx bx-search-alt search-icon"></i>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Start</th>
                                            <th class="text-center">End</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Created At</th>
                                            <th class="text-center">Updated At</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="or in orseries" v-bind:key="or.id">
                                            <td class="text-center">{{or.name}}</td>
                                            <td class="text-center">{{or.start}}</td>
                                            <td class="text-center">{{or.end}}</td>
                                            <td class="text-center">
                                                <span v-if="or.status == 0" class="badge badge-lg badge-success">Active</span>
                                                <span v-else class="badge badge-danger">Inactive</span>
                                            </td>
                                            <td class="text-center">{{or.created_at}}</td>
                                            <td class="text-center">{{or.updated_at}}</td>
                                            <td class="text-center">
                                                <button v-if="or.status == 0" @click="status(or.id)" class="btn btn-sm btn-danger waves-effect waves-light">Deactivate</button>
                                                <button v-else @click="status(or.id)" class="btn btn-sm btn-success waves-effect waves-light">Activate</button>
                                            </td>
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
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">New OR Series</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            
                            <form @submit.prevent="create">
                                <div class="modal-body">
                                    <div class="col-md-12" style="margin-top: 15px;">
                                        <div class="row customerform">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="float-label">Name <code style="color: red;" v-if="errors.name">({{ errors.name[0] }})</code></label>
                                                    <input placeholder="Enter OR Series name" type="text" v-model="ors.name" class="form-control" style="text-transform:capitalize;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="float-label">Start <code style="color: red;" v-if="errors.start">({{ errors.start[0] }})</code></label>
                                                    <input placeholder="Enter Starter" type="text" v-model="ors.start" class="form-control" style="text-transform:capitalize;">
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="float-label">End <code style="color: red;" v-if="errors.end">({{ errors.end[0] }})</code></label>
                                                    <input placeholder="Enter Endor" type="text" v-model="ors.end" class="form-control" style="text-transform:capitalize;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</template>

<script>
export default {
    data(){
        return{
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            dropdownlists: [],
            orseries: [],
            ors: {
                id: '',
                name : '',
                start : '',
                end: '',
                type : '',
                status: ''
            },
            type: '',
            keyword : '',
            selected: 1,
            editable : false
        }
    },

    created(){
        this.getDDList();
    },

    methods : {

        makePagination(meta, links) {
            let pagination = {
                current_page: meta.current_page,
                last_page: meta.last_page,
                next_page_url: links.next,
                prev_page_url: links.prev,
                total: meta.total
            };
            this.pagination = pagination;
        },

        getDDList(page_url) {
            axios.get('/request/admin/dd/active/OR Category')
            .then(response => {
                this.dropdownlists = response.data.data;
                this.type = this.dropdownlists[0].id;
                this.fetch();
                this.pick(this.type);
            })
            .catch(err => console.log(err));
        },

        fetch(page_url) 
        {
            let vm = this; 
            page_url = page_url || this.currentUrl + '/request/finance/orseries/list';

            axios.post(page_url,{
                keyword: this.keyword,
                type: this.type
            })
            .then(response => {
                this.orseries = response.data.data;;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        create() {
            if (this.editable === false) {
                axios.post(this.currentUrl + '/request/finance/orseries/store', {
                    name: this.ors.name,
                    start: this.ors.start,
                    end: this.ors.end,
                    type: this.type,
                })
                .then(response => {
                    this.ors = {};
                    this.fetch();
                    $("#new").modal("hide");
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            } else {
                axios.put(this.currentUrl + '/request/finance/orseries/store', {
                    id: this.ors.id,
                    name: this.ors.name,
                    start: this.ors.start,
                    end: this.ors.end,
                    type: this.type,
                })
                .then(response => {
                    this.editable = false;
                    let page_url = '/request/finance/orseries/list?page=' + this.pagination.current_page;
                    this.fetch(page_url);
                    $("#new").modal("hide");
                })
                .catch(error => {
                    if (error.response.status == 422) {
                        this.errors = error.response.data.errors;
                    }
                });
            }
        },


        pick(number)
        {
            this.selected = number;
            this.type = number;
            this.fetch();
        },

        status(id){
            axios.post(this.currentUrl + '/request/finance/orseries/status', {
                id : id
            })
            .then(response => {
                let page_url = '/request/finance/orseries/list?page=' + this.pagination.current_page;
                this.fetch(page_url);
            })
            .catch(err => console.log(err));
        },

        addnew(){
            $("#new").modal("show");
        },
    }
}
</script>