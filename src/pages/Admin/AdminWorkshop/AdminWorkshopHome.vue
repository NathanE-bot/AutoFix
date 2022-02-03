<template>
    <q-page class="flex flex-center">
        <div class="row w-80">
          <div class="row col-12 j-sp-between">
            <div class="col-5 p-0">
              <div class="row col-12 w-95">
                <div class="col-12 j-sp-between">
                  <div class="col-6 j-start txt-white flex a-end fs-20">
                    <span>Total Income</span>
                  </div>
                  <div class="col-6 j-end" style="gap: 0.5rem;">
                    <q-select
                      v-model="dataHitAPI.month3"
                      :options="listMonth"
                      outlined dense
                      class="br-10px default-select-2 white-1bg"
                    />
                    <q-select
                      v-model="dataHitAPI.year3"
                      :options="listYear"
                      outlined dense
                      class="br-10px default-select-2 white-1bg"
                    />
                    <q-btn
                      @click="doGetSumAllPriceEstimationWorkshop()"
                      color="primary"
                      unelevated dense
                      label="Search"
                      padding="0px 20px"
                      class="br-10px tf-capitalize"
                    />
                  </div>
                </div>
              </div>
              <div class="white-1bg br-10px-i br-10px-i-svg w-95 mt-5">
                <apexchart width="100%" height="215" :options="spark1" :series="spark1.series"></apexchart>
              </div>
            </div>
            <div class="col-7">
              <div class="row col-12 br-10px-i">
                <div class="row col-12">
                  <div class="col-6 j-start txt-white flex a-end fs-20">
                    <span>Daily Total Done Order</span>
                  </div>
                  <div class="col-6 j-end" style="gap: 0.5rem;">
                    <q-select
                      v-model="dataHitAPI.month"
                      :options="listMonth"
                      outlined dense
                      class="br-10px default-select-2 white-1bg"
                    />
                    <q-select
                      v-model="dataHitAPI.year"
                      :options="listYear"
                      outlined dense
                      class="br-10px default-select-2 white-1bg"
                    />
                    <q-btn
                      @click="doGetCountAllDataWorkshop()"
                      color="primary"
                      unelevated dense
                      label="Search"
                      padding="0px 20px"
                      class="br-10px tf-capitalize"
                    />
                  </div>
                </div>
              </div>
              <div class="col-8">
                <div class="row fw">
                  <div class="white-1bg col-12 br-10px-i mt-5">
                    <div>
                      <apexchart width="100%" height="200" type="bar" :options="options1" :series="options1.series1"></apexchart>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12 mt-10" style="min-height: 200px;">
            <div class="row col-12">
              <div class="col-6 j-start txt-white flex a-end fs-20">
                <span>Monthly Total Order</span>
              </div>
              <div class="col-6 j-end" style="gap: 0.5rem;">
                <q-select
                  v-model="dataHitAPI.month2"
                  :options="listMonth"
                  outlined dense
                  class="br-10px default-select-2 white-1bg"
                />
                <q-select
                  v-model="dataHitAPI.year2"
                  :options="listYear"
                  outlined dense
                  class="br-10px default-select-2 white-1bg"
                />
                <q-btn
                  @click="doGetCountWorkshopByStatus()"
                  color="primary"
                  unelevated dense
                  label="Search"
                  padding="0px 20px"
                  class="br-10px tf-capitalize"
                />
              </div>
            </div>
            <div class="white-1bg br-10px-i mt-5">
              <apexchart width="100%" height="200" type="bar" :options="options2" :series="options2.series2"></apexchart>
            </div>
          </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import VueApexCharts from "vue3-apexcharts";
import { getYearWorkshopForFilterHome, getCountAllDataWorkshop, getCountWorkshopByStatus, getSumAllPriceEstimationWorkshop } from '../../../api/AdminWorkshopServices'
import { LocalStorage } from 'quasar'
import help from '../../../js/help'
import ValidationFunction from '../../../js/ValidationFunction'

export default {
  components: {
    apexchart: VueApexCharts,
  },
  data () {
    return {
      ValidationFunction,
      help,
      loader: false,
      user: {},
      totalEstimasi: null,
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
        month2: {
          label: null,
          value: null
        },
        month3: {
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
        },
        year3: {
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
          name: 'series-1',
          data: []
        }],
        colors: ['#21a17b']
      },
      options2: {
        series2: [
          {
            name: 'Done',
            data: []
          },{
            name: 'Rejected',
            data: []
          },{
            name: 'Cancel',
            data: []
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
        colors:['#21a17b','#d32f2f','#373c68'],
        dataLabels: {
          enabled: false
        },
        // stroke: {
        //   show: true,
        //   width: 2,
        //   colors: ['transparent']
        // },
        xaxis: {
          categories: ['1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31']
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
          data: [] //isi datanya disini
        }],
        labels: [...Array(31).keys()].map(n => `2018-09-0${n+1}`), //ini tanggal
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
          text: ValidationFunction.convertToRupiah(3300000),
          offsetX: 30,
          style: {
            fontSize: '24px',
            cssClass: 'apexcharts-yaxis-title'
          }
        },
        subtitle: {
          text: 'Monthly Total Estimation Income',
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
    this.user = LocalStorage.getItem('autoRepairUser').data.user
    // this.doGetFirstLoadData()
  },
  mounted(){
    this.doGetFirstLoadData()
  },
  methods: {
    doGetFirstLoadData(){
      this.loader = true

      this.dataHitAPI.adminID = this.user.id
      this.dataHitAPI.month.value = help.formatToday(help.data().m_1)
      this.dataHitAPI.month.label = help.formatToday(help.data().m_2)

      this.dataHitAPI.month2.value = help.formatToday(help.data().m_1)
      this.dataHitAPI.month2.label = help.formatToday(help.data().m_2)

      this.dataHitAPI.month3.value = help.formatToday(help.data().m_1)
      this.dataHitAPI.month3.label = help.formatToday(help.data().m_2)

      getYearWorkshopForFilterHome().then(response =>{
        response.data.map(val => {
          let tempObj = {
            label: null
          }
          tempObj.label = val.year
          this.listYear.push(tempObj)
        })
        this.dataHitAPI.year.label = this.listYear[0].label
        this.dataHitAPI.year2.label = this.listYear[0].label
        this.dataHitAPI.year3.label = this.listYear[0].label
        this.doGetCountAllDataWorkshop()
        this.doGetCountWorkshopByStatus()
        this.doGetSumAllPriceEstimationWorkshop()
      })
      this.loader = false
    },
    doGetSumAllPriceEstimationWorkshop(){
      this.loader = true
      
      this.spark1.series[0].data = [0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0]
      this.spark1.title.text = ''
      getSumAllPriceEstimationWorkshop(this.user.id, this.dataHitAPI.month3.value, this.dataHitAPI.year3.label)
      .then(response => {
        response.data.ReturnDaily.map(val => {
          this.spark1.series[0].data[val.day-1] = val.Total_Estimasi
        })
          this.totalEstimasi = response.data.ReturnTotal.Total_Estimasi // revisi, belum bisa masuk ke title, text biar jadi dynamis
      })

      this.loader=false
    },
    doGetCountAllDataWorkshop(){
      this.loader = true

      this.options1.series1[0].data =  ['0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0']

      getCountAllDataWorkshop(this.user.id, this.dataHitAPI.month.value, this.dataHitAPI.year.label)
      .then(response => {
        response.data.map(val => {
          this.options1.series1[0].data[val.day-1] = val.countData
        })
      })
      this.loader = false
    },
    doGetCountWorkshopByStatus(){
      this.loader = true

      this.options2.series2[0].data = ['0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0']
      this.options2.series2[1].data = ['0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0']
      this.options2.series2[2].data = ['0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0']

      getCountWorkshopByStatus(this.user.id, this.dataHitAPI.month2.value, this.dataHitAPI.year2.label).then(response => {
        
        console.log(response.data)

        response.data.doneArray.map(val => {
          this.options2.series2[0].data[val.day-1] = val.countData
        })

        response.data.rejectedArray.map(val => {
          this.options2.series2[1].data[val.day-1] = val.countData
        })

        response.data.cancelledArray.map(val => {
          this.options2.series2[2].data[val.day-1] = val.countData
        })
      })

      this.loader = false
    }
  }
}
</script>