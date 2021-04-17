<template>
    <div class="d-xl-flex">
        <div class="w-100">
            <div class="d-md-flex">

                <div class="card filemanager-sidebar mr-md-2">
                    <div class="card-body">
                        <div class="d-flex flex-column h-100">
                            <div class="mb-4">
                                <a class="text-body font-weight-medium py-1 d-flex align-items-center">
                                    <i class="mdi mdi-beaker font-size-18 text-warning mr-2"></i> {{ lab }}
                                </a>
                                <div class="border-bottom mt-3"></div>
                                <div class="mail-list mt-4">
                                    <a @click="change(1)" :class="{active:selected == 1}">
                                        <i class="mdi mdi-format-list-bulleted mr-2"></i> 
                                        All 
                                    </a>
                                    <a @click="change(2)" :class="{active:selected == 2}">
                                        <i class="mdi mdi-format-list-checkbox mr-2"></i>Pending
                                    </a>
                                    <a @click="change(3)" :class="{active:selected == 3}">
                                        <i class="mdi mdi-format-list-bulleted-square mr-2"></i>Ongoing
                                    </a>
                                    <a @click="change(4)" :class="{active:selected == 4}">
                                        <i class="mdi mdi-format-list-checks mr-2"></i>Finished
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-100">
                    <div class="card">
                        <div class="card-body">

                            <div class="row mb-3">
                                <div class="col-xl-4">
                                    <multiselect    
                                        @input="onChangeSample(sampletype.id)" 
                                        v-model="sampletype" 
                                        :options="sampletypes" 
                                        placeholder="Select Sampletype"
                                        @remove="removeSample"
                                        label="name" track-by="id">
                                    </multiselect>
                                </div>
                                <div class="col-xl-8">
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
                                            <th>Sample Code</th>
                                            <th class="text-center">Testname</th>
                                            <th class="text-center">Received Date</th>
                                            <th class="text-center">Due Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Analyst</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="analysis in analyses" v-bind:key="analysis.id"  @click="show(analysis)" style="cursor: pointer;">
                                            <td class="font-weight-bold">{{analysis.samplecode}}</td>
                                            <td class="text-center">{{analysis.testname}}</td>
                                            <td class="text-center">{{analysis.received_date}}</td>
                                            <td class="text-center">{{analysis.due_date}}</td>
                                            <td class="text-center">
                                                <span v-if="analysis.status == 'Finished'" class="badge badge-lg badge-success">Finished</span>
                                                <span v-else-if="analysis.status == 'Ongoing'" class="badge badge-lg badge-info">Ongoing</span>
                                                <span v-else class="badge badge-danger">Pending</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="team">
                                                    <a class="team-member d-inline-block" data-toggle="tooltip" data-placement="top" title="" :data-original-title="analysis.analyst">
                                                        <img  :src="currentUrl+'/images/avatars/'+analysis.analyst_avatar" class="rounded-circle avatar-xs m-1" alt="">
                                                    </a>

                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <nav aria-label="Page navigation example">
                                <ul class="pagination justify-content-end mb-2">
                                    <li class="page-item"><a class="page-link" v-bind:class="[{disabled: !pagination.prev_page_url}]" @click="fetch(pagination.prev_page_url)">Previous</a></li>
                                    <li class="page-item"><a class="page-link">Page {{ pagination.current_page }} of {{ pagination.last_page }}</a></li>
                                    <li class="page-item"><a class="page-link" v-bind:class="[{disabled: !pagination.next_page_url}]" @click="fetch(pagination.next_page_url)">Next</a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="modal fade exampleModal" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">

                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">{{ analysis.samplecode}} 
                                    <!-- <span class="badge badge-soft-success font-size-14 ml-1" v-if="due.status == 'Completed'"> {{ due.status }}</span> -->
                                    <span class="badge badge-soft-warning font-size-14 ml-1" v-if="analysis.status == 'Pending'"> {{ analysis.status }}</span>
                                    <span class="badge badge-soft-info font-size-14 ml-1" v-else> {{ analysis.status }}</span>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div class="modal-body">
                                <div class="p-2">
                                    <h4 class="card-title">Method: </h4>
                                    <p class="card-title-desc">{{analysis.method}}</p>
                                    
                                    <div class="media" v-if="analysis.status != 'Pending'">   
                                        <div class="media-body">
                                            <h5 class="font-size-12">Analyst :</h5>
                                            <p class="text-muted"><i class="bx bx-calendar mr-1"></i>{{ analysis.analyst}}</p>
                                        </div> 
                                        <div class="media-body">
                                            <h5 class="font-size-12">End date :</h5>
                                            <p class="text-muted"><i class="bx bx-calendar mr-1"></i>{{ (analysis.analyst_end == 'Jan 01, 1970 8:00 am') ? 'Not Available' : analysis.analyst_end }}</p>
                                        </div> 
                                    </div>
                                    <div class="media" v-if="analysis.status != 'Pending'">   
                                        <div class="media-body">
                                            <h5 class="font-size-12">Start date :</h5>
                                            <p class="text-muted"><i class="bx bx-calendar mr-1"></i>{{ analysis.analyst_start }}</p>
                                        </div> 
                                        <div class="media-body">
                                            <h5 class="font-size-12">End date :</h5>
                                            <p class="text-muted"><i class="bx bx-calendar mr-1"></i>{{ (analysis.analyst_end == 'Jan 01, 1970 8:00 am') ? 'Not Available' : analysis.analyst_end }}</p>
                                        </div> 
                                    </div>
                                    <hr>
                                    <div class="media">   
                                        <div class="media-body">
                                            <h5 class="font-size-12">Sample Type :</h5>
                                            <p class="text-muted">{{ analysis.sampletype }}</p>
                                        </div> 
                                        <div class="media-body">
                                            <h5 class="font-size-12">Test Name :</h5>
                                            <p class="text-muted">{{ analysis.testname }}</p>
                                        </div> 
                                    </div>
                                    <div class="media ">  
                                        <div class="media-body">
                                            <h5 class="font-size-12">Received Date :</h5>
                                            <p class="text-muted">{{ analysis.received_date }}</p>
                                        </div>   
                                        <div class="media-body">
                                            <h5 class="font-size-12">Due Date :</h5>
                                            <p class="text-muted">{{ analysis.due_date }}</p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="media-body">
                                        <h5 class="font-size-12 mb-1">Description</h5>
                                        <p class="text-muted"><em>{{analysis.sampledescription}}</em></p>
                                    </div>
                                    <div class="media-body">
                                        <h5 class="font-size-12 mb-1">Customer Description</h5>
                                        <p class="text-muted"><em>{{analysis.samplecustomerdescription}}</em></p>
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
        </div>
    </div>
</template>

<script>
import Multiselect from 'vue-multiselect'
export default {
    props: ['lab'],
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            analyses: [],
            analysis: '',
            sampletypes : [],
            sampletype: '',
            keyword : '',
            selected: 1,
            status : 'all'
        }
    },

    created(){
        this.fetchSampletype();
        // this.search();
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

        fetch(page_url)
        {
            let vm = this; let val; let key;
            (this.sampletype != '' && this.sampletype != null) ? val = this.sampletype.id : val = 'all';
            (this.keyword != '' && this.keyword != null) ? key = this.keyword : key = 'all';


            page_url = page_url || this.currentUrl + '/request/lab/analyses/lists/'+val+'/'+this.status+'/'+key;
            axios.get(page_url)
            .then(response => {
                this.analyses = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        },

        fetchSampletype() {
            axios.get(this.currentUrl + '/request/lab/sampletypes')
            .then(response => {
                this.sampletypes = response.data.data;
                this.fetch();
            })
            .catch(err => console.log(err));
        },

        onChangeSample() {
            this.fetch();
        },

        removeSample(value) {
            this.sampletype = '';
            this.fetch();
        },

        change(number){
            this.selected = number;
            if(number == 1){
                this.status = 'all';
                this.fetch();
            }else if(number == 2){
                this.status = 'Pending';
                this.fetch();
            }else if(number == 3){
                this.status = 'Ongoing';
                this.fetch();
            }else{
                this.status = 'Finished';
                this.fetch();
            }
        },

        show(analysis){
            this.analysis = analysis;
            $("#show").modal('show');
        },  
        
        search(){
            let vm = this; let val;
            (this.sampletype != '' && this.sampletype != null) ? val = this.sampletype.id : val = 'all';

            axios.post(this.currentUrl + '/request/lab/analyses/lists', {
                keyword: this.keyword,
                sampletype: val,
                status: this.status
            })
            .then(response => {
                this.analyses = response.data.data;
                vm.makePagination(response.data.meta, response.data.links);
            })
            .catch(err => console.log(err));
        }
    },  components: { Multiselect }
}
</script>