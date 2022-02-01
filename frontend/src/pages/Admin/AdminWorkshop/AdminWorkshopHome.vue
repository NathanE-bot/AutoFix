<template>
    <q-page class="flex flex-center">
        <div class="row w-80">
          <div class="row col-12 j-sp-between">
            <div class="col-4 p-0">
              <div class="white-1bg br-10px-i w-95">
                <apexchart width="100%" height="215" :options="spark1" :series="spark1.series"></apexchart>
              </div>
            </div>
            <div class="col-8">
              <div class="row fw">
                <div class="white-1bg col-md-12 br-10px-i">
                  <div>
                    <apexchart width="100%" height="200" type="bar" :options="options1" :series="options1.series1"></apexchart>
                  </div>
                </div>
               </div>
            </div>
          </div>
          <div class="col-12 mt-10" style="min-height: 200px;">
            <div class="white-1bg br-10px-i">
              <apexchart width="100%" height="200" type="bar" :options="options2" :series="options2.series"></apexchart>
            </div>
          </div>
          <!-- <div class="col-md-12 q-gutter-y-md" >
            <div class="row">
              <div class="white-1bg chart">
                <apexchart width="100%" :options="spark1" :series="spark1.series"></apexchart>
              </div>
              <div class="white-1bg ml-5">
                <div class="row filternya j-end q-gutter-lg">
                  <div>Year</div>
                  <div>Month</div>
                  <div>Search</div>
                </div>
                <div class="row white-1bg chart">
                  <apexchart width="100%" height="200" type="bar" :options="options2" :series="options2.series"></apexchart>
                </div>
              </div>
            </div>
            <div class="row fw">
              <div class="col-md-12 filternya j-end txt-white q-gutter-x-md">
                <div>
                  Year
                </div>
                <div>
                  Month
                </div>
                <div>
                  Search
                </div>
              </div>
              <div class="white-1bg col-md-12 chart h-50 br-10px-i">
                <div>
                  <apexchart width="100%" height="200em" type="bar" :options="options1" :series="options1.series1"></apexchart>
                </div>
              </div>
            </div>
          </div> -->
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import VueApexCharts from "vue3-apexcharts";

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data () {
    return {
      options1: {
        chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30']
          // categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        },
        series1: [{
          name: 'series-1',
          data: [30, 40, 45, 50, 49, 60, 70, 91, 100, 70,30, 40, 45, 50, 49, 60, 70, 91, 100, 70,30, 40, 45, 50, 49, 60, 70, 91, 100, 70]
        }],
      },
      options2: {
        series: [
          {
            name: 'Approved',
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94, 100, 90]
          },{
            name: 'Rejected',
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66, 50, 70]
          }
        ],
        chart: {
          type: 'bar',
          columnWidth: '100%'
        },
        plotOptions: {
          bar: {
            horizontal: false,
            columnWidth: '50%',
            endingShape: 'rounded'
          },
        },
        colors:['#21a17b','#d32f2f'],
        dataLabels: {
          enabled: false
        },
        // stroke: {
        //   show: true,
        //   width: 2,
        //   colors: ['transparent']
        // },
        xaxis: {
          categories: ['Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
        // yaxis: {
        //   title: {
        //     text: '$ (thousands)'
        //   }
        // },
        fill: {
          opacity: 1
        },
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " insurance claim request"
            }
          }
        }
      },
      spark1: {
        chart: {
          id: 'sparkline1',
          // group: 'sparklines',
          type: 'area',
          sparkline: {
            enabled: true
          },
        },
        grid:{
          show: true
        },
        stroke: {
          curve: 'straight'
        },
        fill: {
          opacity: 1,
        },
        series: [{
          name: 'Total Estimation',
          data: [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19, 46] //isi datanya disini
        }],
        labels: [...Array(24).keys()].map(n => `2018-09-0${n+1}`), //ini tanggal
        yaxis: {
          min: 0
        },
        xaxis: {
          type: 'datetime',
          labels: {
            show: false
          }
        },
        colors: ['#21a17b'],
        title: {
          text: '$424,652',
          offsetX: 30,
          style: {
            fontSize: '24px',
            cssClass: 'apexcharts-yaxis-title'
          }
        },
        subtitle: {
          text: 'Sales',
          offsetX: 30,
          style: {
            fontSize: '14px',
            cssClass: 'apexcharts-yaxis-title'
          }
        }
      }
    }
  },
  created() {
  },
  methods: {
  }
}
</script>