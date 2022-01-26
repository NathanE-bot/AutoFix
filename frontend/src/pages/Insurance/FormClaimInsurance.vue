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
                <q-separator color="#605A5A" size="1px" />
            </template>

            <q-step
                :name="1"
                :style="{
                    height: window.heightAltered + 'px',
                    maxHeight: window.heightAltered + 'px'
                }"
            >
                <div class="row d-flex a-start j-sp-between">
                    <div class="col-md-5 row">
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
                        <div class="">
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
                :style="{
                    height: window.heightAltered + 'px',
                    maxHeight: window.heightAltered + 'px'
                }"
            >
                <div class="row d-flex a-start j-sp-between">
                    <div class="col-md-5 row">
                        <q-input
                            v-model="form.namaPengemudiSaatKejadan"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Name of the driver at the time of the incident" />
                        <q-input
                            v-model="form.SIM"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Driver license number" />
                        <q-input
                            v-model="form.hubunganDenganTertanggung"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Relationship with the insured" />
                        <q-input
                            v-model="form.tempatKejadian"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Place of scene" />
                    </div>
                    <div class="col-md-5 row">
                        <q-input
                            v-model="form.kecepatanKendaraan"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Speed on incident" />
                        <q-input
                            v-model="form.tanggalKejadian"
                            class="col-md-5 mr-auto icon-hover-input" filled bottom-slots
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
                            class="col-md-5 ml-auto icon-hover-input" filled bottom-slots
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
                            class="col-md-12 fix-txt-field" filled bottom-slots
                            label="Usage of the vehicle"
                        />
                    </div>
                </div>
            </q-step>

            <q-step
                :name="3"
                :style="{
                    height: window.heightAltered + 'px',
                    maxHeight: window.heightAltered + 'px'
                }"
            >
                <div class="row a-start j-sp-between">
                    <div class="col-md-5 row">
                        <div class="d-flex flex-dir-col mb-20">
                            <div class="text-h6">Is the vehicle registered as an online taxi?</div>
                            <div>
                                <q-checkbox v-model="form.isOnlineTaxi" @click="form.isNotOnlineTaxi = false" size="lg" label="Yes" />
                                <q-checkbox v-model="form.isNotOnlineTaxi" @click="form.isOnlineTaxi = false" size="lg" label="No" />
                            </div>
                        </div>
                        <div class="d-flex flex-dir-col">
                            <div class="text-h6">Was the vehicle hit by another vehicle?</div>
                            <div class="d-flex a-center">
                                <q-checkbox v-model="form.wasHit" @click="form.wasNotHit = false" size="lg" label="Yes" />
                                <q-checkbox v-model="form.wasNotHit" @click="form.wasHit = false" size="lg" label="No" />
                            </div>
                            <div class="p-20 hitter-form-container" v-if="form.wasHit">
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
                        </div>
                    </div>
                    <div class="col-md-5 row q-col-gutter-y-md">
                        <div class="col-12">
                            <div>
                                <div class="text-h6">Choose the type of workshop you want</div>
                                <div class="text-subtitle2 red-txt">*If there is a workshop of your choice, please include it in the chronology</div>
                            </div>
                            <q-select
                                outlined class="default-select-2 w-80"
                            >
                            </q-select>
                        </div>
                        <div class="col-12">
                            <span class="text-h6">Explain the chronology of events</span>
                            <q-input
                                outlined counter maxlength="500"
                                type="textarea" placeholder="Explain the chronology.."
                                class="fix-txt-field default-textarea-1"
                            >
                            </q-input>
                        </div>
                    </div>
                </div>
            </q-step>

            <!-- <q-step
                :name="4"
                :style="{
                    height: window.heightAltered + 'px',
                    maxHeight: window.heightAltered + 'px'
                }"
            >
                <div class="row q-col-gutter-md">
                    <div class="col-12">
                        <div>
                            <div class="text-h6">Choose the type of workshop you want</div>
                            <div class="text-subtitle2 red-txt">*If there is a workshop of your choice, please include it in the chronology</div>
                        </div>
                        <q-select
                            outlined class="default-select-2 w-30"
                        >
                        </q-select>
                    </div>
                    <div class="col-6">
                        <span class="text-h6">Explain the chronology of events</span>
                        <q-input
                            outlined counter maxlength="500"
                            type="textarea" placeholder="Explain the chronology.."
                            class="fix-txt-field default-textarea-1"
                        >
                        </q-input>
                    </div>
                </div>
            </q-step> -->

            <q-step
                :name="4"
                :style="{
                    height: window.heightAltered + 'px',
                    maxHeight: window.heightAltered + 'px'
                }"
            >
                <div>
                    <div class="text-h6 mb-20">Upload photo of the car's condition</div>
                    <div class="row q-gutter-lg">
                        <div class="col-4 upload-photo-box" v-for="(i, index) in imageForm" :key="'UP' + index">
                            <q-input class="upload-photo-name" borderless dense v-model="i.name" placeholder="Input your photo's name" />
                            <i v-if="!i.uploaded" class="fas fa-cloud-upload-alt fs-40 flex flex-center" style="width:100px; height: 100px"></i>
                            <div :class="['upload-photo-box-insurance relative-position flex-center', {'d-none' : !i.uploaded}]">
                                <img class="responsive_img d-flex m-auto br-10-bot" :src="i.imageFile" :id="'myImg-' + index">
                            </div>
                            <input v-if="!i.uploaded" style="color: transparent; width:92px" class="cursor-pointer" type="file" accept=".png,.jpg,.jpeg" :id="'uploadDPUser-' + index" @change="doUploadProfilePicture($event, i, index)">
                        </div>
                        <div class="d-flex a-center j-center">
                            <q-btn
                                v-if="imageForm.length < 5"
                                @click="addUploadPhoto()"
                                icon="fas fa-plus"
                                flat round color="grey-5"
                            />
                            <div v-else-if="imageForm.length == 5">
                                Max 5 total photo
                            </div>
                        </div>
                    </div>
                </div>
            </q-step>

            <template v-slot:navigation>
                <q-separator color="#605A5A" size="1px" />
                <q-stepper-navigation class="d-flex a-center j-sp-between">
                    <div class="d-flex a-center j-end q-gutter-x-md">
                        <div>
                            <i class="fas fa-phone mr-8"></i>
                            <span>087893248938</span>
                        </div>
                        <div>
                            <i class="far fa-envelope mr-8"></i>
                            <span>email@gmail.com</span>
                        </div>
                    </div>
                    <div>
                        <q-btn
                            v-if="step > 1"
                            @click="$refs.stepper.previous()"
                            padding="6px 32px"
                            rounded flat
                            label="Back"
                            color="primary"
                            class="mr-20 tf-capitalize"
                        />
                        <q-btn
                            @click="step === 4 ? doSubmitInsuranceForm() : $refs.stepper.next()"
                            padding="6px 32px"
                            rounded unelevated
                            :label="step === 4 ? 'Submit' : 'Next'"
                            class="tf-capitalize"
                            color="primary"
                        />
                    </div>
                </q-stepper-navigation>
            </template>
        </q-stepper>
    </q-page>
</template>

<script>
import Swal from 'sweetalert2'
/* eslint-disable */
import help from '../../js/help'

export default {
    data () {
        return{
            help,
            step: 3,
            window: {
                width: 0,
                height: 0,
                heightAltered: 0
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
                isOnlineTaxi: false,
                isNotOnlineTaxi: false,
                wasHit: false,
                wasNotHit: false,
                namaPenabrak: null,
                nomorMobilPenabrak: null
            },
            imageForm: [],
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
    created () {
        this.addUploadPhoto()
    },
    mounted () {
        window.addEventListener('resize', this.handleResize)
        this.handleResize()
    },
    unmounted () {
        window.removeEventListener('resize', this.handleResize)
    },
    methods: {
        doSubmitInsuranceForm () {
            Swal.fire ({
                icon: "success",
                title: "Form Submitted",
                text: "Your request is being processed"
            })
        },
        doUploadProfilePicture (event, item, index) {
            var inputFile = event.target.files || event.dataTransfer.files
            if(!inputFile.length) return null

            var inputFileType = inputFile[0].type
            if(!help.isValidImageType(inputFileType)){
                Swal.fire ({
                    icon: "error",
                    title: "Input Error",
                    text: "File type is not .png, .jpg, or .jpeg"
                })
                document.getElementById('uploadDPUser-' + index).value = ''
            }
            item.uploaded = true
            var reader = new FileReader() // Creating reader instance from FileReader() API

            var preview = document.getElementById('myImg-' + index) // Image reference
            var file = inputFile[0] // File refrence

            reader.addEventListener("load", function () { // Setting up base64 URL on image
                preview.src = reader.result
            }, false)
            reader.readAsDataURL(file)

            const formData = new FormData
            formData.set('image', file)
            item.imageFile = formData
        },
        addUploadPhoto () {
            const tempObj = {
                name: '',
                imageFile: [],
                uploaded: false
            }
            this.imageForm.push(tempObj)
        },
        handleResize () {
            this.window.width = window.innerWidth
            this.window.height = window.innerHeight
            this.window.heightAltered = window.innerHeight - (window.innerHeight * (35/100))
        }
    }
}
</script>