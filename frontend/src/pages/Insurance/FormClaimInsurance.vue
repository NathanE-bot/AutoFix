<template>
    <q-page class="insurance_layout_2 flex flex-center">
        <q-stepper
            v-model="step"
            ref="stepper"
            color="primary"
            animated contracted
            class="w-95 insurance_form_layout"
        >
            <template v-slot:message>
                <div class="d-flex a-center j-center position-relative py-15">
                    <h5 class="fw-bold m-0">Form Claim Insurance</h5>
                    <img class="responsive_img logo-img-form" width="120" src="~assets/images/logo/allianz.png" alt="">
                </div>
            </template>

            <q-step
                :name="1"
                :done="step > 1"
                :style="{height: window.heightAltered + 'px'}"
            >
                <div class="row d-flex a-start j-sp-between">
                    <div class="col-md-5 q-gutter-y-lg row">
                        <q-input
                            v-model="form.name"
                            :rules="rules.name_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Insured Name" />
                        <q-input
                            v-model="form.phoneNumber"
                            :rules="rules.phoneNumber_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Phone Number" />
                        <q-input
                            v-model="form.email"
                            :rules="rules.email_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Email" />
                        <q-input
                            v-model="form.brandType"
                            :rules="rules.brandType_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Vehicle Brand and Type" />
                        <q-input
                            v-model="form.nomorRangka"
                            :rules="rules.nomorRangka_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Vehicle Identification Number" />
                    </div>
                    <div class="col-md-5 row d-flex flex-dir-col j-sp-between">
                        <div class="q-gutter-y-lg">
                            <q-input
                                v-model="form.address"
                                :rules="rules.address_r"
                                lazy-rules="ondemand"
                                type="textarea"
                                class="col-md-12 fix-txt-field mb-20" filled
                                label="Address"
                            />
                            <div class="row col-md-12 d-flex a-center j-sp-between q-gutter-y-lg">
                                <q-input
                                v-model="form.polisNumber"
                                    :rules="rules.polisNumber_r"
                                    lazy-rules="ondemand"
                                    class="col-md-5" filled
                                    label="No. Polis" />
                                <q-input
                                    v-model="form.polisiNumber"
                                    :rules="rules.polisiNumber_r"
                                    lazy-rules="ondemand"
                                    class="col-md-5" filled
                                    label="Police Number / Vehicle Registration Number" />
                            </div>
                        </div>
                    </div>
                </div>
            </q-step>

            <q-step
                :name="2"
                :done="step > 2"
                :style="{height: window.heightAltered + 'px'}"
            >
                <div class="row d-flex a-start j-sp-between">
                    <div class="col-md-5 q-gutter-y-xl row">
                        <q-input
                            v-model="form.namaPengemudiSaatKejadan"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Name of the driver at the time of the incident" />
                        <q-input
                            v-model="form.SIM"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Driver license number" />
                        <q-input
                            v-model="form.hubunganDenganTertanggung"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Relationship with the insured" />
                        <q-input
                            v-model="form.tempatKejadian"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Place of scene" />
                    </div>
                    <div class="col-md-5 q-gutter-y-xl row">
                        <q-input
                            v-model="form.kecepatanKendaraan"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Speed on incident" />
                        <q-input
                            v-model="form.tanggalKejadian"
                            class="col-md-5 mr-auto icon-hover-input" filled
                            label="Incident Date"
                        >
                            <template v-slot:append>
                                <q-icon name="event" class="cursor-pointer">
                                    <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
                                        <q-date v-model="form.tanggalKejadian">
                                        <div class="row items-center justify-end">
                                            <q-btn v-close-popup label="Close" color="primary" flat />
                                        </div>
                                        </q-date>
                                    </q-popup-proxy>
                                </q-icon>
                            </template>
                        </q-input>
                        <q-input
                             v-model="form.jamKejadian"
                            class="col-md-5 ml-auto icon-hover-input" filled
                            label="Incident Time"
                        >
                            <template v-slot:append>
                                <q-icon name="access_time" class="cursor-pointer">
                                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                        <q-time v-model="form.jamKejadian">
                                            <div class="row items-center justify-end">
                                            <q-btn v-close-popup label="Close" color="primary" flat />
                                            </div>
                                        </q-time>
                                    </q-popup-proxy>
                                </q-icon>
                            </template>
                        </q-input>
                        <q-input
                            v-model="form.desc2"
                            lazy-rules="ondemand"
                            type="textarea"
                            class="col-md-12 fix-txt-field" filled
                            label="Usage of the vehicle"
                        />
                    </div>
                </div>
            </q-step>

            <q-step
                :name="3"
                :style="{height: window.heightAltered + 'px'}"
            >
                <div class="row">
                    <div class="col-md-5 row">
                        <div class="d-flex flex-dir-col mb-20">
                            <div class="text-h5">Is the vehicle registered as an online taxi?</div>
                            <q-checkbox v-model="form.yes" size="lg" label="Yes" />
                            <q-checkbox v-model="form.no" size="lg" label="No" />
                        </div>
                        <div class="d-flex flex-dir-col">
                            <div class="text-h5">Was the vehicle hit by another vehicle?</div>
                            <q-checkbox v-model="form.yes" size="lg" label="Yes" />
                            <div class="p-20 hitter-form-container">
                                <div>Please input name and vehicle number of the hitter (vehicle)</div>
                                <div class="q-gutter-y-md">
                                    <q-input
                                        v-model="form.namaPenabrak"
                                        filled
                                        label="Hitter Name"></q-input>
                                    <q-input
                                        v-model="form.nomorMobilPenabrak"
                                        filled
                                        label="Hitter Police Number"
                                    ></q-input>
                                </div>
                            </div>
                            <q-checkbox v-model="form.no" size="lg" label="No" />
                        </div>
                    </div>
                    <div class="col-md-5 row">

                    </div>
                </div>
            </q-step>

            <q-step
                :name="4"
                :style="{height: window.heightAltered + 'px'}"
            >
                <div>
                    <div>
                        <div class="text-h5">Choose the type of workshop you want</div>
                        <div class="text-subtitle2 red-txt">*If there is a workshop of your choice, please include it in the chronology</div>
                    </div>
                    <q-select
                        outlined class="default-select-2 w-30"
                    >
                    </q-select>
                </div>
                <q-card class="br-10px w-70 grey-1bg card-shadow-1">
                    <q-card-section class="pl-30 pr-30">
                        <div class="my-20">
                            <span class="text-h6">Explain the chronology of events</span>
                        </div>
                        <q-input
                            outlined counter maxlength="500"
                            type="textarea" placeholder="Explain the chronology.."
                            class="fix-txt-field default-textarea-1"
                        >
                        </q-input>
                    </q-card-section>
                </q-card>
            </q-step>

            <q-step
                :name="5"
                :style="{height: window.heightAltered + 'px'}"
            >
                <div>
                    <div class="text-h5">Upload photo of the car's condition</div>
                </div>
            </q-step>

            <template v-slot:navigation>
                <q-stepper-navigation class="d-flex a-center j-end">
                    <q-btn
                        v-if="step > 1"
                        @click="$refs.stepper.previous()"
                        padding="6px 32px"
                        rounded flat
                        label="Back"
                        color="primary"
                        class="mr-20"
                    />
                    <q-btn
                        @click="$refs.stepper.next()"
                        padding="6px 32px"
                        rounded unelevated
                        :label="step === 5 ? 'Finish' : 'Next'"
                        color="primary"
                    />
                </q-stepper-navigation>
            </template>
        </q-stepper>
    </q-page>
</template>

<script>
/* eslint-disable */
export default {
    data () {
        return{
            step: 5,
            window: {
                width: 0,
                height: 0,
                heightAltered: 0,
                heightAlteredContent: 0
            },
            form: {
                name: '',
                phoneNumber: '',
                email: '',
                brandType: '',
                nomorRangka: null,
                polisNumber: null,
                polisiNumber: null,
                namaPengemudiSaatKejadan: null,
                SIM: null,
                hubunganDenganTertanggung: null,
                tempatKejadian: null,
                kecepatanKendaraan: null,
                tanggalKejadian: null,
                jamKejadian: null,
                desc2: null,
                yes: false,
                no: false,
                namaPenabrak: null,
                nomorMobilPenabrak: null

            },
            rules: {
                name_r: [
                    v => !!v || 'Nama harus diisi'
                ],
                phoneNumber_r: [
                    v => !!v || 'Nomor telepon harus diisi'
                ],
                email_r: [
                    v => !!v || 'Email harus diisi',
                    v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Format Email Salah'
                ],
                brandType_r: [
                    v => !!v || 'Brand dan tipe harus diisi'
                ],
                nomorRangka_r: [
                    v => !!v || 'Nomor rangka harus diisi'
                ],
                polisNumber_r: [
                    v => !!v || 'Nomor polis harus diisi'
                ],
                polisiNumber_r: [
                    v => !!v || 'Nomor polisi mobil harus diisi'
                ]
            }
        }
    },
    mounted () {
        window.addEventListener('resize', this.handleResize)
        this.handleResize()
    },
    unmounted () {
        window.removeEventListener('resize', this.handleResize)
    },
    methods: {
        handleResize () {
            this.window.width = window.innerWidth
            this.window.height = window.innerHeight
            this.window.heightAltered = window.innerHeight - (window.innerHeight * (35/100))
        }
    }
}
</script>