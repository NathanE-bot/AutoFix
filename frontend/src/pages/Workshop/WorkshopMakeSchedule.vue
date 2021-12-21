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
        <div class="modelServisFragment" v-if="isShown === false">
          <div class="modelServisTitle"><span>Model & Jenis Service</span></div>
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
            <div class="modelServisSubtitle"><span>Pilih layanan yang diperlukan untuk mobil anda</span></div>
            <q-card class="listServis">
              <div class="q-gutter-sm">
                <q-checkbox v-model="checkbox1" label="Servis Berkala" style="font-weight: bolder"/>
              </div>
              <div v-if="checkbox1 === true">
                <q-select class="itemCheckbox1" dense square filled v-model="model" :options="optionsCheckbox1" options-label="label" options-value="value" label="Square filled" />
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
              <q-input class="inputTextArea" type="textarea" counter maxlength="200"></q-input>
            </q-card>
          </div>
          <div class="estimasiContainer">
            <q-card class="estimasiHarga">
              <span>RP.0</span>
              <br/>
              <br/>
              Estimasi Harga
              <br/> <br/>
              <p>*Harga di atas adalah estimasi biaya servis tanpa pekerjaan tambahan. Harga dapat berbeda, sesuai pada tipe mobil & ketentuan pajak.</p>
            </q-card>
            <q-card class="estimasiWaktu">
              <span>0 Jam</span>
              <br/>
              <br/>
              Estimasi Waktu Servis
            </q-card>
          </div>
          <br/>
          <q-btn @click="isShown = !isShown" label="Lanjut" color="primary"/>
        </div>
        <div v-else>
          <q-btn @click="isShown = !isShown" label="Kembali" color="secondary"/>
          <div>
            <!-- :options="dateValidation.minimalDateFromToday(helper.formatToday(helper.data().dmy_3))" -->
            <q-date
              v-model="date"
              minimal
              landscape
            />
          </div>
          tampilan 2
          <q-btn label="Submit" color="primary"/>
        </div>
    </q-page>
</template>

<script>
import dateValidation from '../../js/dateValidation'
import helper from '../../js/help'
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
      checkbox2: false,
      disablePage2: false,
      model: { label: '', value: '' },
      optionsCheckbox1: [
        { label: '1', value: '1' },
        { label: '2', value: '2' },
        { label: '3', value: '3' },
        { label: '4', value: '4' }
      ],
      dateValidation,
      helper
    }
  }
}
</script>
