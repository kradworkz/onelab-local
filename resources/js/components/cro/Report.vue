<template>
<div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="clearfix">
                        <div class="float-left">
                            <div class="input-group input-group-sm">
                                
                                <select v-model="month" class="custom-select custom-select-sm ml-2" style=" width: 100px;">
                                    <option value="All">All</option>
                                    <option value="Daily">Daily</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                <input type="date" v-model="todate" class="custom-select custom-select-sm"  v-if="month == 'Daily'" style="margin-right: 10px; margin-left: 10px;width: 100px;">
                                <select v-else v-model="year" class="custom-select custom-select-sm ml-2" style="margin-right: 10px; width: 100px;">
                                    <option value="2021" selected>2021</option>
                                    <option value="2020">2020</option>
                                    <option value="2019">2019</option>
                                    <option value="2018">2018</option>
                                </select>
                                <select v-model="laboratory" class="custom-select custom-select-sm" style="width: 200px;">
                                    <option :value="lab" v-for="lab in laboratories" v-bind:key="lab.id">{{lab.name}}</option>
                                </select>
                                <div class="input-group-append">
                                    <label class="input-group-text">Services</label>
                                </div>
                            </div>
                        </div>
                        <div class="float-right">
                            <div class="apex-charts" >
                                <div class="toolbar button-items text-center">
                                    <button @click="show = 'bar'" type="button" class="btn btn-light btn-sm">
                                        <i class="bx bx-grid-alt"></i>
                                    </button>
                                    <button @click="show = 'lists'" type="button" class="btn btn-light btn-sm">
                                        <i class="bx bx-list-ul"></i>
                                    </button>
                                    <button @click="print" class="btn btn-sm btn-primary" type="button">
                                        <i class="bx bxs-printer align-middle mr-1"></i> Print
                                    </button>
                                </div>
                                <div id="overview-chart-timeline"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-if="show == 'bar'">
        <div class="col-xl-5">
            <div class="card">
                <div class="card-body">
                    <div>
                        <div>
                            <div class="text-muted">
                                <h5>{{laboratory.name}}</h5>
                                <p class="mb-1">henrywells@abc.com</p>
                                <p class="mb-0">Id no: #SK0234</p>
                            </div>
                        </div>
                        <div class="dropdown ml-2">
                            <a class="text-muted dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="mdi mdi-dots-horizontal font-size-18"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body border-top mb-2 mt-2">
                    <div class="row">
                        <div class="col-sm-6">
                            <div>
                                <p class="text-muted mb-2">Income Generated</p>
                                <h5>₱ {{total[6]}}</h5>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="text-sm-right mt-4 mt-sm-0">
                                <p class="text-muted mb-2">Since last month</p>
                                <h5>+ $ 248.35   <span class="badge badge-success ml-1 align-bottom">+ 1.3 %</span></h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body border-top mb-4 mt-2">
                    <p class="text-muted mb-4">{{ (month == 'All' ? 'In this year ' + year : (month != 'Daily') ? 'In this month '+ months[month.replace(/^0+/, '')-1] : 'In this day '+ todate )}} </p>
                    <div class="text-center">
                        <div class="row">
                            <div class="col-sm-4">
                                <div>
                                    <div class="font-size-24 text-primary mb-2">
                                        <i class="bx bx-send"></i>
                                    </div>
                
                                    <p class="text-muted mb-2">Gratis</p>
                                    <h5>₱ {{total[3]}}</h5>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mt-4 mt-sm-0">
                                    <div class="font-size-24 text-primary mb-2">
                                        <i class="bx bx-import"></i>
                                    </div>
                
                                    <p class="text-muted mb-2">Discount</p>
                                    <h5>₱ {{total[4]}}</h5>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="mt-4 mt-sm-0">
                                    <div class="font-size-24 text-primary mb-2">
                                        <i class="bx bx-wallet"></i>
                                    </div>
                
                                    <p class="text-muted mb-2">Gross</p>
                                    <h5>₱ {{total[5]}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        
        <div class="col-xl-7">
            <div class="row">
                <div class="col-sm-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted mb-2">No. of Requests</p>
                                    <h5 class="mb-0">{{total[0]}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted mb-2">No. of Samples</p>
                                    <h5 class="mb-0">{{total[1]}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="card mini-stats-wid">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <p class="text-muted mb-2">No. of Analysis</p>
                                    <h5 class="mb-0">{{total[2]}}</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title mb-3">Overview</h4>
                    <div>
                        <div id="chart">
                            <apexchart height="240" :options="chartOptions" :series="series"></apexchart>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" v-else>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap mb-0">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th>Month</th>
                                    <th>No. of Requests</th>
                                    <th>No. of Samples</th>
                                    <th>No. of Analyses</th>
                                    <th>Gratis</th>
                                    <th>Discount</th>
                                    <th>Gross</th>
                                    <th>Income Generated</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                <tr v-for="report in reports" v-bind:key="report.id">
                                    <td><a href="javascript: void(0);" class="text-body font-weight-bold">{{(month != 'All') ? months[month.replace(/^0+/, '')-1] : report.month}}</a> </td>
                                    <td>{{report.requests}}</td>
                                    <td>{{report.samples}}</td>
                                    <td>{{report.analysis}}</td>
                                    <td>{{formatPrice(report.gratis)}}</td>
                                    <td>{{formatPrice(report.discount)}}</td>
                                    <td>{{formatPrice(report.gross)}}</td>
                                    <td>{{formatPrice(report.income)}}</td>
                                </tr>
                            </tbody>
                            <tfoot class="thead-light">
                                <tr class="text-center">
                                    <th>Total</th>
                                    <th v-for="sum in total" v-bind:key="sum.id">{{sum}}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
</template>

<script>
import VueApexCharts from 'vue-apexcharts';
export default {
    data(){
        return{
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            reports: [],
            laboratories: [],
            year: new Date().getFullYear(),
            month: 'All', /* ("0" + ((new Date()).getMonth() + 1)).slice(-2) */
            months : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
            todate: '',
            laboratory: '',
            total: [],
            show: 'bar',
            series: [],
            chartOptions: {
               chart: {
                    type: "bar",
                    stacked: !0,
                    toolbar: {
                        show: !1
                    },
                    zoom: {
                        enabled: !0
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: !1,
                        columnWidth: "25%",
                        endingShape: "rounded"
                    }
                },
                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"]
                },
                legend: {
                    position: 'bottom'
                },
                fill: {
                    opacity: 1
                }
            },
        }
    },

    created(){
        this.fetchLocal();
    },
    
    watch : {
        laboratory : function (){
            this.fetch();
        },
        year : function (){
            this.fetch();
        },
        month : function (){
            this.fetch();
        },
        todate : function (){
            this.fetch();
        }
    },

    methods : {
        formatPrice(value) {
            if(value != '-'){
                let val = (value/1);
                return val.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")
            }else{
                return '-';
            }
        },

        fetchLocal() {
            axios.get(this.currentUrl + '/request/admin/dd/active/' + 'Laboratory')
            .then(response => {
                this.laboratories = response.data.data;
                this.laboratory = this.laboratories[0];
            })
            .catch(err => console.log(err));
        },

        fetch(){
            this.total = [];
            axios.post(this.currentUrl + '/request/cro/reports', {
                year: this.year,
                month: this.month,
                todate: this.todate,
                laboratory: this.laboratory.id
            })
            .then(response => {
                this.reports = response.data;
                
                let requests = [];
                let samples = [];
                let analysis = [];
                let income = [];
                let gratis = [];
                let discount = [];
                let gross = [];

                Object.entries(this.reports).forEach(([key, val]) => {
                    if(val.requests != '-'){
                        requests.push(val.requests) 
                        samples.push(val.samples) 
                        analysis.push(val.analysis) 
                        income.push(val.income) 
                        gratis.push(val.gratis) 
                        discount.push(val.discount) 
                        gross.push(val.gross) 
                    }
                });

                this.series = [
                    {
                        name: 'No. of Request',
                        data: requests
                    },
                    {
                        name: 'No. of Samples',
                        data: samples
                    },
                    {
                        name: 'No. of Analysis',
                        data: analysis
                    },
                ];

                console.log(this.series);

                this.total.push(requests.reduce(function(requests, num){ return requests + num }, 0));
                this.total.push(samples.reduce(function(samples, num){ return samples + num }, 0));
                this.total.push(analysis.reduce(function(analysis, num){ return analysis + num }, 0));
                this.total.push(this.formatPrice(gratis.reduce(function(gratis, num){ return gratis + num }, 0)));
                this.total.push(this.formatPrice(discount.reduce(function(discount, num){ return discount + num }, 0)));
                this.total.push(this.formatPrice(gross.reduce(function(gross, num){ return gross + num }, 0)));
                this.total.push(this.formatPrice(income.reduce(function(income, num){ return income + num }, 0)));

            })
            .catch(err => console.log(err));
        },

        print(){
            axios.get(this.currentUrl + '/request/cro/print')
            .then(response => {
            })
            .catch(err => console.log(err));
        }
    }, components: { apexchart: VueApexCharts }
}
</script>