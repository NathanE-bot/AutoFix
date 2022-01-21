<template>
    <q-page class="flex flex-center">
        <div class="row w-60 m-auto">
          <div class="col-md-12 q-gutter-y-md" >
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
              <div class="white-1bg col-md-12 chart h-50">
                <div>
                  <apexchart width="100%" height="300em" type="line" :options="options" :series="series"></apexchart>
                </div>
              </div>
            </div>
            <div class="row fw">
              <div class="col-md-12 filternya j-end txt-white">
                  Filter DIKANAN
                </div>
              <div class="white-1bg col-md-12 chart"> CHART </div>
            </div>
          </div>
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
      options: {
        chart: {
          id: 'vuechart-example'
        },
        xaxis: {
          categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
        }
      },
      series: [{
        name: 'series-1',
        data: [30, 40, 45, 50, 49, 60, 70, 91]
      }]
    }
  }
}
</script>
