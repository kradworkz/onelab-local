<template>
<div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="media">
                                <div class="mr-3">
                                    <img :src="currentUrl+'/images/avatars/'+profile.avatar" alt="" class="avatar-md rounded-circle img-thumbnail">
                                </div>
                                <div class="media-body align-self-center">
                                    <div class="text-muted">
                                        <h5 class="mb-1">{{profile.firstname}} {{profile.lastname}}</h5>
                                        <p class="mb-0 text-truncate">{{user.type}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 align-self-center">
                            <div class="text-lg-center mt-4 mt-lg-0">
                                <div class="row">
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Referral Requests</p>
                                            <h5 class="mb-0">48</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Local Requests</p>
                                            <h5 class="mb-0">40</h5>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div>
                                            <p class="text-muted text-truncate mb-2">Clients</p>
                                            <h5 class="mb-0">18</h5>
                                            
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

    <div class="row">
        <div class="col-xl-6">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title font-size-14 mb-4">Top 10 Samples</h4>
                            <div class="table-responsive" data-simplebar style="max-height: 290px; min-height: 290px;">
                                <table class="table table-centered table-nowrap">
                                    <thead class="thead-light">
                                        <tr class="font-size-12">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th class="text-center">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(sample,key) in samples" v-bind:key="sample.id">
                                            <td style="width: 50px;">
                                                <div class="font-size-12 text-primary">
                                                    {{key + 1}}
                                                </div>
                                            </td>
                                            <td><h5 class="font-size-12 mb-1">{{sample.name}}</h5> </td>
                                            <td class="text-center"> 
                                                <h5 class="font-size-12 text-muted mb-0">{{sample.total}}</h5>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title font-size-14 mb-4">Top 10 Analyses</h4>
                            <div class="table-responsive" data-simplebar style="max-height: 290px; min-height: 290px;">
                                <table class="table table-centered table-nowrap">
                                    <thead class="thead-light">
                                        <tr class="font-size-12">
                                            <th>#</th>
                                            <th>Name</th>
                                            <th class="text-center">Count</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(analysis,key) in analyses" v-bind:key="analysis.id">
                                            <td style="width: 50px;">
                                                <div class="font-size-12 text-primary">
                                                    {{key+1}}
                                                </div>
                                            </td>
                                            <td><h5 class="font-size-12 mb-1">{{analysis.name}}</h5> </td>
                                            <td class="text-center"><h5 class="font-size-12 text-muted mb-0">{{analysis.total}}</h5></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <div id="chart">
                        <apexchart height="315" :options="chartOptions" :series="series"></apexchart>
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
    props: {
        user: {type: Object,required: true },
        profile: {type: Object,required: true }
    },
    data(){
        return {
            currentUrl: window.location.origin,
            errors: [],
            pagination: {},
            series: [],
            samples: [],
            analyses: [],
            chartOptions: {
                chart: {
                    type: "area",
                    toolbar: {
                        show: !1
                    }
                },  
                dataLabels: {
                    enabled: !1
                },
                stroke: {
                    curve: "smooth",
                    width: 2
                },
                fill: {
                    type: "gradient",
                    gradient: {
                        shadeIntensity: 1,
                        inverseColors: !1,
                        opacityFrom: .45,
                        opacityTo: .05,
                        stops: [20, 100, 100, 100]
                    }
                },
                xaxis: {
                    categories: ["Jan", "Feb", "Mar", "Apr", "May", "June", "July", "Aug", "Sep", "Oct", "Nov", "Dec"]
                },
                markers: {
                    size: 3,
                    strokeWidth: 3,
                    hover: {
                        size: 4,
                        sizeOffset: 2
                    }
                },
                legend: {
                    position: "bottom"
                }
            },
        }
    },

    created(){
        this.fetchTop();
        this.fetchServices();
    },

    methods: {
        fetchTop(){
            axios.get(this.currentUrl + '/request/cro/top')
            .then(response => {
                this.samples = response.data[0].['samples'];
                this.analyses = response.data[0].['analysis'];
            })
            .catch(err => console.log(err));
        },

        fetchServices(){
            axios.get(this.currentUrl + '/request/cro/services')
            .then(response => {
                this.series = response.data;
                console.log(this.series);
             
            })
            .catch(err => console.log(err));
        }

    }, components: { apexchart: VueApexCharts }
}
</script>