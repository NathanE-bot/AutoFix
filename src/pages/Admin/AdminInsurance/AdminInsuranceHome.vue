<template>
    <q-page class="flex flex-center">
        <div class="row w-80">
          <div class="row col-12 j-sp-between">
            <div class="row fw">
              <div class="row col-12 br-10px-i">
                <div class="row col-12">
                  <div class="col-6 j-start txt-white flex a-end fs-20">
                    <span>Daily Total Approved and Rejected Insurance Claim Requests</span>
                  </div>
                  <div class="col-6 j-end" style="gap: 1rem;">
                    <q-select
                      v-model="dataHitAPI.month"
                      :options="listMonth"
                      outlined dense
                      class="br-10px admin_select w-20"
                    />
                    <q-select
                      v-model="dataHitAPI.year"
                      :options="listYear"
                      outlined dense
                      class="br-10px admin_select"
                    />
                    <q-btn
                      @click="doGetChartCountDataTotalClaimedInsurance()"
                      color="primary"
                      unelevated dense
                      label="Search"
                      padding="0px 20px"
                      class="br-10px tf-capitalize"
                    />
                  </div>
                </div>
              </div>
              <div class="white-1bg col-12 br-10px-i mt-5">
                <div>
                  <apexchart width="100%" height="200" type="bar" :options="options1" :series="options1.series1"></apexchart>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mt-10" style="min-height: 200px;">
            <div class="row fw">
              <div class="row col-12 br-10px-i">
                <div class="row col-12">
                  <div class="col-6 j-start txt-white flex a-end fs-20">
                      <span>Monthly Insurance Claim Requests</span>
                  </div>
                  <div class="row col-6 j-end" style="gap: 1rem;">
                    <q-select
                      v-model="dataHitAPI.year2"
                      :options="listYear"
                      outlined dense
                      class="br-10px admin_select"
                    />
                    <q-btn
                      @click="doGetCountDataTotalClaimedInsuranceByStatus()"
                      color="primary"
                      unelevated dense
                      label="Search"
                      padding="0px 20px"
                      class="br-10px tf-capitalize"
                    />
                  </div>
                </div>
              </div>
              <div class="white-1bg col-12 br-10px-i mt-5">
                <apexchart width="100%" height="200" type="bar" :options="options2" :series="options2.series2"></apexchart>
              </div>
            </div>
          </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import VueApexCharts from "vue3-apexcharts";
import { getChartCountDataTotalClaimedInsurance, getYearInsuranceForFilterHome, getCountDataTotalClaimedInsuranceByStatus } from '../../../api/AdminInsuranceServices'
import { LocalStorage } from 'quasar'
import help from '../../../js/help'

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data () {
    return {
      help,
      user: {},
      loader: false,
      dateToday: {},
      listYear: [],
      listMonth: [
        { label: 'January', value: 1},
        { label: 'February', value: 2},
        { label: 'March', value: 3},
        { label: 'April', value: 4},
        { label: 'May', value: 5},
        { label: 'June', value: 6},
        { label: 'July', value: 7},
        { label: 'August', value: 8},
        { label: 'September', value: 9},
        { label: 'October', value: 10},
        { label: 'November', value: 11},
        { label: 'December', value: 12},
      ],
      dataHitAPI: {
        adminID: null,
        month: {
          label: null,
          value: null
        },
        year: {
          label: null,
          value: null
        },
        year2: {
          label: null,
          value: null
        }
      },
      options1: {
        chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']
          // categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        },
        series1: [{
          name: 'Total',
          data: []
        }],
        colors: ['#373c68'],
        tooltip: {
          y: {
            formatter: function (val) {
              return val + " insurance claim requests"
            }
          }
        }
      },
      options2: {
        series2: [
          {
            name: 'Approved',
            data: ['0','0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0']
          },{
            name: 'Rejected',
            data: ['0','0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0']
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
        xaxis: {
          categories: ['Jan','Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
        },
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
      }
    }
  },
  created(){
    this.user = LocalStorage.getItem('autoRepairUser').data.user
    this.doGetFirstLoadData()
  },
  mounted () {
    // this.updateSeriesLine()
  },
  methods: {
    updateSeriesLine() {
      this.$refs.realtimeChart.updateSeries([{
        data: this.spark1.series[0].data,
      }], false, true);
    },
    doGetFirstLoadData() {
      this.loader = true
      this.dataHitAPI.month.value = help.formatToday(help.data().m_1)
      this.dataHitAPI.month.label = help.formatToday(help.data().m_2)
      getYearInsuranceForFilterHome().then(response => {
        
        response.data.map(val => {
          let tempObj = {
            label: null
          }
          tempObj.label = val.year
          this.listYear.push(tempObj)
        })
        this.dataHitAPI.year.label = this.listYear[0].label
        this.dataHitAPI.year2.label = this.listYear[0].label
        this.doGetChartCountDataTotalClaimedInsurance()
        this.doGetCountDataTotalClaimedInsuranceByStatus()
      })
      this.loader = false
    },
    doGetChartCountDataTotalClaimedInsurance () {
      this.loader = true
      this.options1.series1[0].data =  ['0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0']
      
      getChartCountDataTotalClaimedInsurance(this.user.id, this.dataHitAPI.month.value, this.dataHitAPI.year.label)
      .then(response => {
        response.data.map(val => {
          this.options1.series1[0].data[val.day-1] = val.countData
        })
      })
      this.loader = false
    },
    doGetCountDataTotalClaimedInsuranceByStatus(){
      this.loader = true
      this.options2.series2[0].data = ['0','0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0']
      this.options2.series2[1].data = ['0','0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0']
      
      getCountDataTotalClaimedInsuranceByStatus(this.user.id, this.dataHitAPI.year2.label)
      .then(response => {
        console.log(response.data)
        response.data.approvedArray.map(val => {
          this.options2.series2[0].data[val.months-1] = val.countData
        })

        response.data.rejectedArray.map(val => {
          this.options2.series2[1].data[val.months-1] = val.countData
        })
      })
      this.loader = false
    }
  }
}
</script>
