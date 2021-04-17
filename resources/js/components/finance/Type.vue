
<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">
                
                <div class="card filemanager-sidebar mr-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                               
                                <div class="mail-list mt-1">
                                    <a @click="pick(1,'Discount')" :class="{active:selected == 1}"><i class="mdi mdi-cash mr-2"></i> Discount </a>
                                    <a @click="pick(2,'Payment Mode')" :class="{active:selected == 2}"><i class="mdi mdi-cash-plus mr-2"></i>Payment Mode</a>
                                    <a @click="pick(3,'Collection Type')" :class="{active:selected == 3}"><i class="mdi mdi-cash-multiple mr-2"></i>Collection Type</a>
                                    <a @click="pick(4,'Deposit Type')" :class="{active:selected == 4}"><i class="mdi mdi-cash-refund mr-2"></i>Deposit Type</a>
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
                                            <th class="text-center" v-if="type == 'Discount'">Percentage</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Created at</th>
                                            <th class="text-center">Updated at</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="dropdownlist in dropdowns" v-bind:key="dropdownlist.id">
                                            <td class="text-center">{{dropdownlist.name}}</td>
                                            <td class="text-center" v-if="dropdownlist.type == 'Discount'">{{dropdownlist.percentage}}%</td>
                                            <td class="text-center">
                                                <span v-if="dropdownlist.status == 0" class="badge badge-lg badge-success">Active</span>
                                                <span v-else class="badge badge-danger">Inactive</span>
                                            </td>
                                            <td class="text-center">{{dropdownlist.created_at}}</td>
                                            <td class="text-center">{{dropdownlist.updated_at}}</td>
                                            <td class="text-center">
                                                <button v-if="dropdownlist.status == 0" @click="status(dropdownlist.id,dropdownlist.status)" class="btn btn-sm btn-danger waves-effect waves-light">Deactivate</button>
                                                <button v-else @click="status(dropdownlist.id,dropdownlist.status)" class="btn btn-sm btn-success waves-effect waves-light">Activate</button>
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
            dropdowns: [],
            keyword : '',
            type: 'Discount',
            selected: 1
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
                prev_page_url: links.prev,
                total: meta.total
            };
            this.pagination = pagination;
        },


        fetch(page_url) 
        {
            let vm = this; 
            page_url = page_url || this.currentUrl + '/request/admin/dd/lists';

            axios.post(page_url,{
                keyword: this.keyword,
                type: this.type
            })
            .then(response => {
                this.dropdowns = response.data.data;;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        pick(number,type)
        {
            this.selected = number;
            this.type = type;
            this.fetch();
        },

        status(id,status){
            axios.post(this.currentUrl + '/request/admin/dd/status', {
                id : id,
                status: status
            })
            .then(response => {
                let page_url = '/request/admin/dd/lists?page=' + this.pagination.current_page;
                this.fetch(page_url);
            })
            .catch(err => console.log(err));
        },
    }
}
</script>