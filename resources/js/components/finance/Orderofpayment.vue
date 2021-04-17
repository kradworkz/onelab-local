
<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">

                <div class="card filemanager-sidebar mr-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                                <!-- <button class="btn btn-danger btn-block" type="button" @click="addnew"> Create Order of Payment </button> -->
                                <div class="mail-list mt-4">
                                    <a v-for="dd in dropdownlists" v-bind:key="dd.id" @click="pick(dd.id)" :class="{active:selected == dd.id}"><i class="mdi mdi-adjust mr-2"></i> {{dd.name}} </a>
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
                                            <th class="text-center">Transaction #</th>
                                            <th class="text-center">Customer</th>
                                            <th class="text-center">Payment Mode</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Created Date</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="transaction in transactions" v-bind:key="transaction.id">
                                            <td class="text-center">{{transaction.transaction_no}}</td>
                                            <td class="text-center">{{transaction.customer}}</td>
                                            <td class="text-center">{{transaction.mode}}</td>
                                            <td class="text-center">
                                                <span v-if="transaction.status == 'Pending'" class="badge badge-lg badge-danger">Unpaid</span>
                                                <span v-else class="badge badge-success">Paid</span>
                                            </td>
                                            <td class="text-center">{{transaction.updated_at}}</td>
                                            <td class="text-center">
                                               <!-- <a :href="'orderofpayment/'+transaction.id" target="_blank" class="btn btn-primary btn-sm btn-rounded">View Details </a> -->
                                               <button @click="viewtransaction(transaction)" type="button" class="btn btn-primary btn-sm btn-rounded">View Details </button>
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

                <div class="modal fade exampleModal" id="showtransaction" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Transaction</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                 <div class="row">
                                    <div class="col-xl-4">
                                        <div class="card overflow-hidden">
                                            <div class="bg-soft-primary">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="text-primary p-3">
                                                            <h5 class="text-primary" style="margin-bottom: 0px;">{{ transaction.customer }}</h5>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="card-body pt-0">
                                                <div class="row">
                                                    <div class="col-sm-12 mt-3">
                                                        <span class="float-right badge badge-pill badge-success font-size-12">{{transaction.status}}</span>
                                                        <h5 class="font-size-15 text-truncate">{{ transaction.transaction_no }}<br> <span class="badge badge-soft-success font-size-10"> (Transaction #) </span></h5>
                                                    </div>
                                                    <div class="col-sm-12 mt-3">
                                                        <h5 class="font-size-14"><i class="bx bx-calendar-check mr-1 text-primary"></i> Due Date</h5>
                                                        <p class="text-muted mb-0">{{ transaction.updated_at }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-body">
                                                <h5 class="font-size-14 card-title mb-4">Request Information</h5>

                                                <div class="table-responsive">
                                                    <table class="table table-nowrap mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <th scope="row">Payment Mode:</th>
                                                                <td>{{ transaction.mode }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Collection Type :</th>
                                                                <td>{{ transaction.collection }}</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">Deposit Type :</th>
                                                                <td>{{ transaction.or.deposit }}</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-8">
                                        <div>
                                            <div class="card-body">
                                                <div class="table-responsive" style="margin-top: -15px;">
                                                    <table class="table table-nowrap">
                                                        <thead>
                                                            <tr>
                                                                <th style="border-top: none !important;">Reference #</th>
                                                                <th style="border-top: none !important;" class="text-right">Subotal</th>
                                                                <th style="border-top: none !important;" class="text-right">Discount</th>
                                                                <th style="border-top: none !important;" class="text-right">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="request in transaction.carts" v-bind:key="request.id">
                                                                <td>{{request.reference}}</td>
                                                                <td class="text-right">₱{{request.subtotal}}</td>
                                                                <td class="text-right">₱{{request.discount}}</td>
                                                                <td class="text-right">₱{{request.total}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="3" class="border-0 text-right"><strong>Total</strong></td>
                                                                <td class="border-0 text-right"><h4 class="m-0">₱{{ formatPrice(total)}}</h4></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                 </div>

                            </div>
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
            transactions: [],
            ors: {
                id: '',
                name : '',
                start : '',
                end: '',
                type : '',
                status: ''
            },
            transaction : {
                transaction_no : '',
                customer: '',
                status: '',
                mode: '',
                collection: '',
                updated_at: '',
                or: {},
                cheque: {},
                carts : []
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

    computed: {
        total() {
            return this.transaction.carts.reduce((acc, item) => parseInt(acc) + parseInt(item.total), 0);
        }
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

        formatPrice(value) {
            let val = (value/1).toFixed(2).replace(',', '.')
            return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
        },

        getDDList(page_url) {
            axios.get('/request/admin/dd/active/Collection Type')
            .then(response => {
                this.dropdownlists = response.data.data;
                this.type = this.dropdownlists[0].id;
                this.pick(this.type);
            })
            .catch(err => console.log(err));
        },

        fetch(page_url) 
        {
            let vm = this; 
            page_url = page_url || this.currentUrl + '/request/finance/orderofpayments/list';

            axios.post(page_url,{
                keyword: this.keyword,
                type: this.type
            })
            .then(response => {
                this.transactions = response.data.data;;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        pick(number)
        {
            this.selected = number;
            this.type = number;
            this.fetch();
        },

        viewtransaction(transaction){
            this.transaction.customer = transaction.customer;
            this.transaction.transaction_no = transaction.transaction_no;
            this.transaction.status = transaction.status;
            this.transaction.mode = transaction.mode;
            this.transaction.collection = transaction.collection;
            this.transaction.updated_at = transaction.updated_at;
            this.transaction.or = transaction.or;
            this.transaction.cheque = transaction.cheque;
            this.transaction.carts = transaction.carts;
            $("#showtransaction").modal('show');
        }
    }
}
</script>