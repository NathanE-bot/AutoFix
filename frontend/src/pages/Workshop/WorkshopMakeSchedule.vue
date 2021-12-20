<template>
    <q-page class="lightGrey-bg">
        <div class="topInfo">
          <img src="" alt="">
          <span>INI DIBAWAH IMAGE</span>
          <div class="detailInfo">
            <span>{{ detail.namaBengkel }} INI NAMA BENGKEL</span>
            <span>{{ detail.kabupaten }} INI KABUPATEN</span>
            <span>{{ detail.rating }} INI RATING</span>
            <br/>
            <p>{{ detail.deskripsiBengkel }} INI DESKRIPSI BENGKEL LOREM Ipsum</p>
          </div>
          <hr/>
        </div>
        <div class="modelServis" v-if="isShown === false">
          <span>Model & Jenis Service</span>
          <br/>
            <q-select
                filled
                v-model="model"
                use-input
                hide-selected
                fill-input
                input-debounce="0"
                :options="options"
                @filter="filterFn"
                placeholder="Pilih model mobil"
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
                filled
                v-model="model"
                use-input
                hide-selected
                fill-input
                input-debounce="0"
                :options="options"
                @filter="filterFn"
                placeholder="Pilih tipe mobil"
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
          <div>
            <span>Pilih layanan yang diperlukan untuk mobil anda</span>
            <q-card class="listServis">
              <div class="q-gutter-sm">
                <q-checkbox v-model="checkbox1" label="Servis Berkala" style="font-weight: bolder"/>
              </div>
              <div v-if="checkbox1 === true">
                BisaDipake
              </div>
              <div class="q-gutter-sm">
                <q-checkbox v-model="checkbox2" label="Perbaikan Umum" style="font-weight: bolder"/>
              </div>
              <div v-if="checkbox2 === true">
                BisaDipake2
              </div>
            </q-card>
          </div>
          <br/>
          <div class="reqTextCard">
            <q-card class="reqServis">
              <p class="infoReqServis" style="font-weight: bolder">Kerusakan Mobil / Permintaan Servis (Opsional)</p>
              <q-input class="inputTextArea" type="textarea"></q-input>
            </q-card>
          </div>
          <q-btn @click="isShown = !isShown" label="Lanjut" color="primary"/>
        </div>
        <div v-else>
          <q-btn @click="isShown = !isShown" label="Kembali" color="secondary"/>
          tampilan 2
          <q-btn label="Submit" color="primary"/>
        </div>
    </q-page>
</template>

<script>
export default {
  data () {
    return {
      detail: {
        namaBengkel: '',
        kabupaten: '',
        rating: 0,
        deskripsiBengkel: ''
      },
      isShown: false,
      checkbox1: false,
      checkbox2: false
    }
  }
}
</script>
