<template>
    <q-page class="pageContainer lightGrey-bg">
        <q-card class="filterContainer">
            <span class="titlePage">Workshop</span>
            <div>
                <q-card-section class="slotInput">
                    <q-select
                        dense
                        filled
                        v-model="model"
                        use-input
                        hide-selected
                        fill-input
                        input-debounce="0"
                        :options="options"
                        @filter="filterFn"
                        placeholder="Cari Workshop..."
                        style="width: 250px"
                    >
                        <template v-slot:no-option>
                        <q-item>
                            <q-item-section class="text-grey">
                              No results
                            </q-item-section>
                        </q-item>
                        </template>
                    </q-select>
                    <q-select
                        dense
                        filled
                        v-model="model"
                        use-input
                        hide-selected
                        fill-input
                        input-debounce="0"
                        :options="options"
                        @filter="filterFn"
                        placeholder="Cari Location..."
                        style="width: 250px"
                    >
                        <template v-slot:no-option>
                        <q-item>
                            <q-item-section class="text-grey">
                              No results
                            </q-item-section>
                        </q-item>
                        </template>
                    </q-select>
                    <q-select dense square style="width: 250px" filled v-model="model" :options="statusBuka" label="Status Buka" />
                <q-btn unelevated color="primary" dense>
                    Search
                </q-btn>
                </q-card-section>
            </div>
        </q-card>
        <div class="totalWorkshop">
          <span>Total Workshop: {{ totalWorkshop }}</span>
        </div>
        <div class="listDetailContainer">
            <div class="q-gutter-md loopList">
                <q-card class="list" v-for="a in 10" :key="a.id">looping data disini</q-card>
            </div>
            <div class="detailList">
                <q-card class="detail">
                  Disini Tampilan
                </q-card>
            </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import { getListWorkshop } from '../../api/workshopService'
export default {
  data () {
    return {
      totalWorkshop: 10,
      statusBuka: [
        { label: 'Semua', value: 'semua' },
        { label: 'Buka', value: 'buka' },
        { label: 'Tutup', value: 'tutup' },
        { label: '24Jam', value: '24jam' }
      ],
      model: '',
      workshops: [],
      tempWorkshops: []
    }
  },
  created () {
    this.doGetListWorkshop()
  },
  methods: {
    doConsole(a){
      console.log(a);
    },
    doGetListWorkshop(){
      let _this = this
      getListWorkshop().then(response => {
        _this.tempWorkshops = response.data.objectReturn
        console.log(_this.tempWorkshops)
      }) .catch((err) =>{
        console.log(err)
      })
    }
  }
}
</script>