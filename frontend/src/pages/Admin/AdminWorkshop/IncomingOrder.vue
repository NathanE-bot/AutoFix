<template>
    <q-page class="p-20" :style="{height: window.heightAltered + 'px'}">
        <div class="text-h6 fw-semibold mb-20">Incoming Order</div>
        <q-scroll-area
          :thumb-style="thumbStyle"
          :bar-style="barStyle"
          class="list-workshop-scrollbar h-80">
            <q-card v-for="n in 10" :key="n" class="adminWorkshop-card w-80 "  >
                <q-card-section >
                    <span class="fs-20 fw-semibold">Honda Pradana</span>
                    <q-separator class="br-5px mt-10" color="#605A5A" size="4px" />
                    <q-card-section class="flex m-auto">
                        <div class="w-40">
                            <div class="flex flex-dir-col mb-10">
                                <span class="fw-semibold">Nama Pelanggan</span>
                                <span>Joko Sutanto</span>
                            </div>
                            <div class="flex flex-dir-col mb-10">
                                <span class="fw-semibold">Tanggal dan Waktu</span>
                                <span>10-Januari-2022</span>
                                <span>17.00</span>
                            </div>
                            <div class="flex flex-dir-col mb-10">
                                <span class="fw-semibold">Model dan Tipe Mobil</span>
                                <span>Model : . . . | Tipe: . . .</span>
                                <!-- ni gw gatau urutannya model dl ap tipe dl -->
                            </div>
                            <div class="flex flex-dir-col mb-10">
                                <span class="fw-semibold">Estimasi waktu pengerjaan</span>
                                <span>. . . Jam</span>
                            </div>
                            <div class="flex flex-dir-col mb-10">
                                <span class="fw-semibold">Estimasi Harga : Rp . . .</span>
                            </div>
                        </div>
                        <div class="w-60">
                            <div class="flex flex-dir-col mb-10">
                                <span class="fw-semibold">Layanan yang dipilih</span>
                            </div>
                        </div>
                    </q-card-section>
                    <q-separator vertical class="br-5px" color="#605A5A" size="4px"/>
                    <div class="d-flex a-center j-end" style="gap: 20px">
                        <q-btn
                            @click="promptReject = true"
                            color="negative" rounded unelevated padding="4px 24px"
                            label="Cancel"
                            class="tf-capitalize"
                        />
                        <q-btn
                            @click="promptAccept = true"
                            color="primary" rounded unelevated padding="4px 24px"
                            label="Accept"
                            class="tf-capitalize"
                        />
                    </div>
                </q-card-section>
            </q-card>
        </q-scroll-area>
        <q-dialog v-model="promptAccept">
            <q-card style="min-width: 480px" class="py-20" >
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Done Schedule?</div>
                </q-card-section>

                <q-card-actions align="center" class="text-primary">
                    <q-btn label="Cancel" v-close-popup  @click="promptReject = false"/>
                    <q-btn color="primary" label="Accept" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
        <q-dialog v-model="promptReject">
            <q-card style="min-width: 640px" class="p-16">
                <q-card-section>
                    <div class="black-1 m-auto fw-semibold text-align-center">Please insert your reason for Canceling</div>
                </q-card-section>
                <div class="m-auto">
                    <q-input
                        outlined
                        type="textarea"
                        class="fix-txt-field default-textarea-1 w-80 m-auto"
                    >
                    </q-input>
                </div>
                <q-card-actions align="right" class="text-primary">
                    <q-btn padding="4px 16px" color="primary" rounded label="Submit" v-close-popup />
                </q-card-actions>
            </q-card>
        </q-dialog>
    </q-page>
</template>

<script>
/* eslint-disable */
// import { getIncomingOrderSchedule } from '../../../api/AdminWorkshopServices'
// import { LocalStorage } from 'quasar'
export default {
    data () {
      return {
        user: [],
        window: {
            width: 0,
            height: 0,
            heightAltered: 0
        },
        thumbStyle: {
            right: '2px',
            borderRadius: '10px',
            backgroundColor: '#21a17b',
            width: '10px',
            opacity: 0.75
        },
        barStyle: {
            right: '2px',
            borderRadius: '10px',
            backgroundColor: '#21a17b',
            width: '10px',
            opacity: 0.2
        },
        promptAccept: false,
        promptReject: false 
      }
    },
    methods: {
    }
}
</script>