<template>
    <div>
        <div class="row">
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <div class="clearfix">
                            <div class="float-right">
                                <div class="input-group input-group-sm">
                                    <select class="custom-select custom-select-sm">
                                        <option selected="" @click="choose('Weekly')">Weekly</option>
                                        <option @click="choose('Monthly')">Monthly</option>
                                        <option @click="choose('Yearly')">Yearly</option>
                                    </select>
                                    <div class="input-group-append">
                                        <label class="input-group-text">Date</label>
                                    </div>
                                </div>
                            </div>
                            <h4 class="card-title mb-4">Todo List</h4>
                        </div>

                        <div class="table-responsive mt-4">
                            <div class="progress" style="height: 20px;">
                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" v-bind:aria-valuenow="count" aria-valuemin="0" v-bind:aria-valuemax="todolists.length" :style="{ width: Math.round(((count/todolists.length)*100)) + '%'}">{{count}} of {{todolists.length}}</div>
                            </div>
                            <table class="table table-centered mb-2 mt-3">
                                <tbody>
                                    <tr>
                                        <td>
                                            <h5 class="font-size-14 mb-1">My Ongoing list</h5>
                                            <p class="text-muted mb-0">{{mypending.length}} to go..</p>
                                        </td>
                                        <td class="text-right">
                                            <p class="text-muted mb-1">Completed</p>
                                            <h5 class="mb-0">{{count}} out of {{todolists.length}}</h5>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="table-responsive" data-simplebar style="max-height: 278px; min-height: 278px;">
                                <table class="table table-centered table-nowrap">
                                    <tbody>
                                        <tr v-for="due in mypending" v-bind:key="due.id" style="cursor: pointer;" @click="showdue(due)">
                                            <td style="width: 15px;">
                                                <div class="font-size-15" :class="{'text-danger':checkdate(due.due_date) == 'yes','text-warning':checkdate(due.due_date) == 'no'}">
                                                    <i class="fas fa-exclamation-circle bx-tada "></i>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <h5 class="font-size-14 mb-1">{{ due.samplecode }}</h5>
                                                    <p class="text-muted mb-0">{{ due.sampletype }}</p>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-right">
                                                    <h5 class="font-size-14 mb-0">{{ due.testname }}</h5>
                                                    <p class="text-muted mb-0">{{ due.due_date }}</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Due Approaching <span class="badge badge-soft-danger font-size-12 ml-1">  less than two days </span></h4>

                        <ul class="nav nav-pills bg-light rounded" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#transactions-all-tab" role="tab" @click="fetchDue('Pending')">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#transactions-all-tab" role="tab" @click="fetchDue('Ongoing')">Ongoing</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-4">
                            <div class="tab-pane active" id="transactions-all-tab" role="tabpanel">
                                <div class="table-responsive" data-simplebar style="max-height: 330px; min-height: 330px;">
                                    <table class="table table-centered table-nowrap">
                                        <tbody>
                                            <tr v-for="due in duedates" v-bind:key="due.id" style="cursor: pointer;" @click="showdue(due)">
                                                <td style="width: 15px;">
                                                    <div class="font-size-15" :class="{'text-danger':checkdate(due.due_date) == 'yes','text-warning':checkdate(due.due_date) == 'no'}">
                                                        <i class="fas fa-exclamation-circle bx-tada "></i>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <h5 class="font-size-14 mb-1">{{ due.samplecode }}</h5>
                                                        <p class="text-muted mb-0">{{ due.sampletype }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-right">
                                                        <h5 class="font-size-14 mb-0">{{ due.testname }}</h5>
                                                        <p class="text-muted mb-0">{{ due.due_date }}</p>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-4">Samples <span class="badge badge-soft-warning font-size-12 ml-1">  more than two days </span></h4>

                        <ul class="nav nav-pills bg-light rounded" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="tab" href="#transactions-all-tab2" role="tab" @click="fetchPending('Pending')">Pending</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#transactions-all-tab2" role="tab" @click="fetchPending('Ongoing')">Ongoing</a>
                            </li>
                        </ul>
                        <div class="tab-content mt-4">
                            <div class="tab-pane active" id="transactions-all-tab2" role="tabpane2">
                                <div class="table-responsive" data-simplebar style="max-height: 330px; min-height: 330px;">
                                    <table class="table table-centered table-nowrap">
                                        <tbody>
                                            <tr v-for="due in pendingdates" v-bind:key="due.id" style="cursor: pointer;" @click="showdue(due)">
                                                <td style="width: 15px;">
                                                    <div class="font-size-15" :class="{'text-warning':due.status == 'Pending','text-info':due.status == 'Ongoing','text-success':due.status == 'Completed'}">
                                                        <i class="bx bx-bell bx-tada"></i>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div>
                                                        <h5 class="font-size-14 mb-1">{{ due.samplecode }}</h5>
                                                        <p class="text-muted mb-0">{{ due.sampletype }}</p>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="text-right">
                                                        <h5 class="font-size-14 mb-0">{{ due.testname }}</h5>
                                                        <p class="text-muted mb-0">{{ due.due_date }}</p>
                                                    </div>
                                                </td>
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

        <div class="modal fade exampleModal" id="show" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ due.samplecode}} 
                            <!-- <span class="badge badge-soft-success font-size-14 ml-1" v-if="due.status == 'Completed'"> {{ due.status }}</span> -->
                            <span class="badge badge-soft-warning font-size-14 ml-1" v-if="due.status == 'Pending'"> {{ due.status }}</span>
                            <span class="badge badge-soft-info font-size-14 ml-1" v-else> {{ due.status }}</span>
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="p-2">
                            <span class="float-right">  <i class="bx bx-calendar mr-1"></i> 15 Oct, 19</span>
                            <h4 class="card-title">Method: </h4>
                            <p class="card-title-desc">{{due.method}}</p>
                            <hr>
                            <div class="media">   
                                <div class="media-body">
                                    <h5 class="font-size-12">Sample Type :</h5>
                                    <p class="text-muted">{{ due.sampletype }}</p>
                                </div> 
                                <div class="media-body">
                                    <h5 class="font-size-12">Test Name :</h5>
                                    <p class="text-muted">{{ due.testname }}</p>
                                </div> 
                            </div>
                             <div class="media ">  
                                <div class="media-body">
                                    <h5 class="font-size-12">Received Date :</h5>
                                    <p class="text-muted">{{ due.received_date }}</p>
                                </div>   
                                <div class="media-body">
                                    <h5 class="font-size-12">Due Date :</h5>
                                    <p class="text-muted">{{ due.due_date }}</p>
                                </div>
                            </div>
                            <hr>
                            <div class="media-body">
                                <h5 class="font-size-12 mb-1">Description</h5>
                                <p class="text-muted"><em>{{due.sampledescription}}</em></p>
                            </div>
                            <div class="media-body">
                                <h5 class="font-size-12 mb-1">Customer Description</h5>
                                <p class="text-muted"><em>{{due.samplecustomerdescription}}</em></p>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" @click="updatestatus(due.id,'Ongoing')" class="btn btn-primary" v-if="due.status == 'Pending'">Start</button>
                        <button type="button" @click="updatestatus(due.id,'Completed')" class="btn btn-primary" v-else-if="this.userid == due.analyst_id && due.status == 'Ongoing'">Finish</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        props: ['userid'],
        data(){
            return {
                currentUrl: window.location.origin,
                errors: [],
                pagination: {},
                dues: [],
                due: '',
                ongoings: [],
                pendings: [],
                todolists: [],
                mypending: [],
                status: 'Weekly',
                count : 0
            }
        },

        created(){
            this.fetchDue('Pending');
            this.fetchPending('Pending');
            this.todolist();
        },

        computed: {
            duedates: function() {
                return this.dues.sort((a, b) => new Date(a.due_date) - new Date(b.due_date))
            },
            ongoingdates: function() {
                return this.ongoings.sort((a, b) => new Date(a.due_date) - new Date(b.due_date))
            },
            pendingdates: function() {
                return this.pendings.sort((a, b) => new Date(a.due_date) - new Date(b.due_date))
            }
        },

        methods : {
            fetchDue(status){
                axios.get(this.currentUrl + '/request/lab/analyses/'+status)
                .then(response => {
                    this.dues = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchOngoing(status){
                axios.get(this.currentUrl + '/request/lab/analyses/'+status)
                .then(response => {
                    this.ongoings = response.data.data;
                })
                .catch(err => console.log(err));
            },

            fetchPending(status){
                axios.get(this.currentUrl + '/request/lab/analyses/waiting/'+status)
                .then(response => {
                    this.pendings = response.data.data;
                })
                .catch(err => console.log(err));
            },

            checkdate(duedate){
                var inputDate = new Date(duedate);

                // Get today's date
                var todaysDate = new Date();

                // call setHours to take the time out of the comparison
                if(inputDate.setHours(0,0,0,0) == todaysDate.setHours(0,0,0,0)) {
                   return 'yes';
                }else{
                    return 'no'
                }
            },

            showdue(due){
                $("#show").modal('show');
                this.due = due;
            },

            updatestatus(id,status){
                axios.post(this.currentUrl + '/request/lab/analysis/status', {
                    id : id,
                    status: status
                })
                .then(response => {
                    this.due = response.data.data;
                    this.fetchDue('Pending');
                    this.fetchPending('Pending');
                    this.todolist();
                    $("#show").modal('hide');
                    Vue.$toast.success('<strong>Testing Started</strong>', {
                        position: 'bottom-left'
                    });
                })
                .catch(err => console.log(err));
            },

            todolist(){
                this.count = 0;
                this.mypending = [];
                axios.get(this.currentUrl + '/request/lab/analysis/todolist/'+this.status)
                .then(response => {
                    this.todolists = response.data.data;
                    for(var i=0; i < this.todolists.length; i++){
                        if(this.todolists.length > 0){
                            if(this.todolists[i].status == 'Ongoing'){
                                this.mypending.push(this.todolists[i]);
                            }else{
                                this.count += 1;
                            }
                        }
                    } 
                })
                .catch(err => console.log(err));
            },

            choose(status){
                this.status = status;
                this.todolist();
            }
        }
    }
</script>