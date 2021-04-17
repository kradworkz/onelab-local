<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">              

                <div class="w-100">
                    <div class="card">
                        <div class="card-body">

                            <div>
                                <div class="row mb-3">
                                   
                                </div>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Definition</th>
                                            <th class="text-center">Fee</th>
                                            <th class="text-center">Created at</th>
                                            <th class="text-center">Updated at</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="test in addons" v-bind:key="test.id">
                                            <td class="text-center">{{test.method}}</td>
                                            <td class="text-center">{{test.reference}}</td>
                                            <td class="text-center">{{test.fee}}</td>
                                            <td class="text-center">{{test.created_at}}</td>
                                            <td class="text-center">{{test.updated_at}}</td>
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
    import Multiselect from 'vue-multiselect'
    export default {
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                addons : [],
                keyword: ''
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
                page_url = page_url || this.currentUrl + '/request/admin/addons/';

                axios.get(page_url)
                .then(response => {
                    this.addons = response.data.data;;
                    vm.makePagination(response.data.meta, response.data.links);
                })
                .catch(err => console.log(err));
            },
           

            search() {
                let vm = this;
                axios.post(this.currentUrl + '/request/admin/addon/search', {
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

