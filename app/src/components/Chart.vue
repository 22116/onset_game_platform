<template>
    <div>
        <apexchart type=line height=350 :options="chartOptions" :series="series" />
        <b-progress :value="current" :max="data.length" show-progress animated></b-progress>
    </div>
</template>

<script>
import ApexCharts from 'vue-apexcharts'

export default {
    components: {
        apexchart: ApexCharts,
    },
    props: {
        data: Array,
        current: Number
    },
    computed: {
        series: function() {
            return [{
                data: this.data
            }];
        }
    },
    data: function () {
        return {
            chartOptions: {
                tooltip: {
                    enabled: false
                },
                labels: [],
                legend: {
                    show:false
                },
                chart: {
                    toolbar: {
                        show: false
                    },
                    height: 350,
                    zoom: {
                        enabled: false
                    }
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    curve: 'smooth'
                },
                grid: {
                    xaxis: {
                        lines: {
                            show: false,
                        }
                    },
                    yaxis: {
                        lines: {
                            show: false,
                        }
                    },
                },
                xaxis: {
                    labels: {
                        show: false,
                    },
                    axisTicks: {
                        show: false,
                    },
                    axisBorder: {
                        show: false,
                    }
                },
                yaxis: {
                    labels: {
                        show: false,
                    }
                },
            }
        }},
}
</script>
