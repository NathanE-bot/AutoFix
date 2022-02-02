<template>
    <q-page class="insurance_layout_2 flex flex-center">
        <q-stepper
            v-model="step"
            ref="stepper"
            color="primary"
            animated contracted
            class="w-95 m-auto insurance_form_layout"
        >
            <template v-slot:message>
                <div class="d-flex a-center j-center py-15">
                    <h5 class="fw-bold m-0">Claim Insurance Form</h5>
                    <div class="position-relative">
                        <img class="responsive_img logo-img-form fit-content" width="120" height="42" :src="help.checkForInsuranceLogo(vendorInsurance.logo)" alt="">
                    </div>
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
                <q-form
                    ref="formStepper1"
                    class="row d-flex a-start j-sp-between"
                >
                    <div class="col-md-5 row q-gutter-y-md">
                        <q-input
                            v-model="form.insuredName"
                            :rules="rules.insuredName_r"
                            lazy-rules="ondemand"
                            class="col-md-12 q-field--with-bottom" filled
                            label="Insured Name" />
                        <q-input
                            v-model="form.phoneNumber"
                            :rules="rules.phoneNumber_r"
                            lazy-rules="ondemand"
                            mask="############"
                            class="col-md-12" filled
                            label="Phone Number" />
                        <q-input
                            v-model="form.email"
                            :rules="rules.email_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled
                            label="Email" />
                        <q-input
                            v-model="form.carTypeAndBrand"
                            :rules="rules.carTypeAndBrand_r"
                            lazy-rules="ondemand"
                            hint="Ex. Nissan Grand Livina"
                            class="col-md-12" filled
                            label="Vehicle Brand and Type" />
                        <q-input
                            v-model="form.chassisNumber"
                            :rules="rules.chassisNumber_r"
                            lazy-rules="ondemand"
                            hint="Ex. 1HGBH41JXMN109186"
                            class="col-md-12" filled
                            label="Chassis Number / VIN" />
                    </div>
                    <div class="col-md-5 row q-gutter-y-md">
                        <q-input
                            v-model="form.addressClaimer"
                            :rules="rules.addressClaimer_r"
                            lazy-rules="ondemand"
                            type="textarea"
                            class="col-md-12 fix-txt-field mb-20" filled
                            label="Address"
                        />
                        <div class="col-md-12 row j-sp-between">
                            <q-input
                                v-model="form.polisNumber"
                                :rules="rules.polisNumber_r"
                                lazy-rules="ondemand"
                                class="col-md-5" filled
                                label="No. Polis" />
                            <q-input
                                v-model="form.licensePlateNumber"
                                :rules="rules.licensePlateNumber_r"
                                lazy-rules="ondemand"
                                class="col-md-5" filled
                                label="License Plate Number"
                                hint="Ex. B 1234 CDE"
                            />
                        </div>
                    </div>
                </q-form>
            </q-step>

            <q-step
                :name="2"
                :style="{
                    height: window.heightAltered + 'px',
                    maxHeight: window.heightAltered + 'px'
                }"
            >
                <q-form
                    ref="formStepper2"
                    class="row d-flex a-start j-sp-between"
                >
                    <div class="col-md-5 row q-gutter-y-md">
                        <q-input
                            v-model="form.driverName"
                            :rules="rules.driverName_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Name of the driver at the incident" />
                        <q-input
                            v-model="form.driverLicense"
                            :rules="rules.driverLicense_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Driver license number" />
                        <q-input
                            v-model="form.driverRelation"
                            :rules="rules.driverRelation_r"
                            lazy-rules="ondemand" hint="Ex. Mother/Son/Cousin/etc. Note: If it's yourself type myself / saya"
                            class="col-md-12" filled bottom-slots
                            label="Relation with the insured" />
                        <q-input
                            v-model="form.incidentLocation"
                            :rules="rules.incidentLocation_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Incident Location" />
                    </div>
                    <div class="col-md-5 row q-gutter-y-md">
                        <q-input
                            v-model="form.driverSpeed"
                            :rules="rules.driverSpeed_r"
                            lazy-rules="ondemand"
                            class="col-md-12" filled bottom-slots
                            label="Speed during incident"
                            suffix="km/h" mask="###"
                        />
                        <q-input
                            v-model="form.incidentDate"
                            :rules="rules.incidentDate_r"
                            lazy-rules="ondemand"
                            hint="Ex. 2021/08/20"
                            mask="####/##/##"
                            class="col-md-5 mr-auto icon-hover-input" filled bottom-slots
                            label="Incident Date"
                        >
                            <template v-slot:append>
                                <q-icon name="event" class="cursor-pointer">
                                    <q-popup-proxy ref="qDateProxy" cover transition-show="scale" transition-hide="scale">
                                        <q-date v-model="form.incidentDate" :options="(date) => date <= help.formatToday(help.data().dmy_3)">
                                        <div class="row items-center justify-end">
                                            <q-btn v-close-popup label="Close" color="primary" flat />
                                        </div>
                                        </q-date>
                                    </q-popup-proxy>
                                </q-icon>
                            </template>
                        </q-input>
                        <q-input
                            v-model="form.incidentTime"
                            :rules="rules.incidentTime_r"
                            lazy-rules="ondemand"
                            hint="Ex. 14:40"
                            mask="##:##"
                            class="col-md-5 ml-auto icon-hover-input" filled bottom-slots
                            label="Incident Time"
                        >
                            <template v-slot:append>
                                <q-icon name="access_time" class="cursor-pointer">
                                    <q-popup-proxy cover transition-show="scale" transition-hide="scale">
                                        <q-time v-model="form.incidentTime">
                                            <div class="row items-center justify-end">
                                            <q-btn v-close-popup label="Close" color="primary" flat />
                                            </div>
                                        </q-time>
                                    </q-popup-proxy>
                                </q-icon>
                            </template>
                        </q-input>
                        <q-input
                            v-model="form.vehicleDescription"
                            :rules="rules.driverSpeed_r"
                            lazy-rules="ondemand"
                            hint="Ex. vehicles used to transport goods"
                            type="textarea"
                            class="col-md-12 fix-txt-field" filled bottom-slots
                            label="The use of the vehicle on incident"
                        />
                    </div>
                </q-form>
            </q-step>

            <q-step
                :name="3"
                :style="{
                    height: window.heightAltered + 'px',
                    maxHeight: window.heightAltered + 'px'
                }"
            >
                <q-form ref="formStepper3">
                    <div class="row a-start j-sp-between">
                        <div class="col-md-5 row">
                            <div class="d-flex flex-dir-col mb-20">
                                <div class="text-h6">Is the vehicle registered as an online taxi?</div>
                                <div>
                                    <q-checkbox v-model="form.isOnlineTaxi" @click="form.isNotOnlineTaxi = false" size="lg" label="Yes" />
                                    <q-checkbox v-model="form.isNotOnlineTaxi" @click="form.isOnlineTaxi = false" size="lg" label="No" />
                                </div>
                                <span v-if="errorMessage && !form.isOnlineTaxi && !form.isNotOnlineTaxi" class="red-txt">*please check either one</span>
                            </div>
                            <div class="d-flex flex-dir-col">
                                <div class="text-h6">Was the vehicle hit by another vehicle?</div>
                                <div class="d-flex a-center">
                                    <q-checkbox v-model="form.wasHit" @click="form.wasNotHit = false" size="lg" label="Yes" />
                                    <q-checkbox v-model="form.wasNotHit" @click="form.wasHit = false" size="lg" label="No" />
                                </div>
                                <span v-if="errorMessage && !form.wasNotHit && !form.wasHit" class="red-txt mb-10">*please check either one</span>
                                <div class="p-20 hitter-form-container" v-if="form.wasHit">
                                    <div class="text-subtitle2 pb-10">Please input the name and phone number of the hitter</div>
                                    <div class="q-gutter-y-md">
                                        <q-input
                                            v-model="form.incidentStatusDescription"
                                            :rules="form.wasHit ? rules.driverName_r : rules.emptyRule"
                                            outlined counter maxlength="50" autogrow
                                            type="textarea" placeholder="Andy, 087239457433"
                                            class="fix-txt-field default-textarea-1 fix-textarea-height"
                                        >
                                        </q-input>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 row q-col-gutter-y-md">
                            <div class="col-12">
                                <div>
                                    <div class="text-h6">Choose the type of workshop you want</div>
                                    <div class="text-subtitle2 red-txt mb-10">*If there is a workshop of your choice, please <b>include it in the chronology</b> and pick "Workshop of my own choice".</div>
                                </div>
                                <q-select
                                    v-model="form.workshopTypeObj"
                                    :options="vendorWorkshops"
                                    :error="help.isObjectEmpty(form.workshopTypeObj) && errorMessage"
                                    outlined class="default-select-2 w-80"
                                >
                                    <template v-slot:selected>
                                        <template v-if="!help.isObjectEmpty(form.workshopTypeObj)">
                                            {{ form.workshopTypeObj.label }}
                                        </template>
                                        <template v-else>
                                            <span class="placeholder-text">Choose workshop of your choice</span>
                                        </template>
                                    </template>
                                </q-select>
                            </div>
                            <div class="col-12">
                                <span class="text-h6">Explain the chronology of events</span>
                                <q-input
                                    v-model="form.chronology"
                                    :rules="rules.chronology_r"
                                    lazy-rules="ondemand"
                                    outlined counter maxlength="500"
                                    type="textarea" placeholder="Explain the chronology.."
                                    class="fix-txt-field default-textarea-1"
                                >
                                </q-input>
                            </div>
                        </div>
                    </div>
                </q-form>
            </q-step>

            <q-step
                :name="4"
                :style="{
                    height: window.heightAltered + 'px',
                    maxHeight: window.heightAltered + 'px'
                }"
            >
                <div class="pb-20">
                    <div class="text-h6 mb-8">Claim insurance procedure online</div>
                    <div class="mb-20 class p-10 negative_bg_fade-1 br-5px w-mc">
                        <div>
                            <span><b class="red-txt">IMPORTANT NOTE!</b> Required photo document for claim insurance online include:</span>
                            <div class="d-flex a-start">
                                <div class="d-flex flex-dir-col">
                                    <span>1. Driver's license</span>
                                    <span>2. Driver's ID Card</span>
                                    <span>3. Driver's Car Registration <b>(both sides)</b></span>
                                    <span>4. Front and rear view of the vehicle <b>(license plate number included in both photo)</b></span>
                                </div>
                                <div class="d-flex flex-dir-col ml-10">
                                    <span>5. Left and right view of the vehicle</span>
                                    <span>6. <b>Damaged</b> section from afar</span>
                                    <span>7. <b>Damaged</b> section up close while <b>pointing</b> at the damaged direction</span>
                                    <span>8. Chassis number and vehicle kilometer</span>
                                </div>
                            </div>
                            <div class="d-flex flex-dir-col">
                                <span class="mt-8"><b>SIDE NOTE: </b> Please input <b>photo's name</b> first before uploading the photo.</span>
                                <span class="mt-8">Best photo format is landscape and minimal resolution of 300 x 150</span>
                            </div>
                        </div>
                    </div>
                    <q-form ref="formStepper4">
                        <div :class="['row j-start w-100 m-auto']">
                            <div class="px-12 mb-15" v-for="(image, index) in imageForm" :key="'UPE' + index">
                                <q-input
                                    v-model="image.name"
                                    dense filled placeholder="Input your photo's name"
                                    class="input-text-center"
                                >
                                </q-input>
                                <div class="form-insurance-images relative-position br-10-bot">
                                    <img :class="['responsive_img fit-content br-10-bot', {'w-0 z-opacity' : help.isDataEmpty(image.imageFile)}]" width="300" height="150" :src="image.imageFile"  :id="'myImg-' + index" alt="">
                                    <i v-if="help.isDataEmpty(image.imageFile)" class="fas fa-cloud-upload-alt fs-40 upload-cloud-icon"></i>
                                </div>
                                <input style="color: transparent; width: 92px" class="cursor-pointer mt-10" type="file" accept=".png,.jpg,.jpeg" :id="'uploadDPUser-' + index" @change="doUploadProfilePicture($event, image, index)">
                            </div>
                            <div class="d-flex a-center j-center">
                                <q-btn
                                    v-if="imageForm.length < 20"
                                    @click="addUploadPhoto(false)"
                                    icon="fas fa-plus"
                                    flat round color="grey-5"
                                />
                                <div v-else-if="imageForm.length == 20">
                                    Max total photo 20
                                </div>
                            </div>
                        </div>
                    </q-form>
                </div>
            </q-step>
            <template v-slot:navigation>
                <q-separator color="#605A5A" size="1px" />
                <q-stepper-navigation class="d-flex a-center j-sp-between">
                    <div class="d-flex a-center j-end q-gutter-x-md" v-if="!help.isDataEmpty(vendorInsurance.phoneNumber && vendorInsurance.email)">
                        <span>Contact Us: </span>
                        <div v-if="!help.isDataEmpty(vendorInsurance.phoneNumber)">
                            <i class="fas fa-phone mr-8"></i>
                            <span>{{ vendorInsurance.phoneNumber }}</span>
                        </div>
                        <div v-if="!help.isDataEmpty(vendorInsurance.email)">
                            <i class="far fa-envelope mr-8"></i>
                            <span>{{ vendorInsurance.email }}</span>
                        </div>
                    </div>
                    <div class="v-else"><!-- Sementara pake ini klo gk ada datanya --></div>
                    <div>
                        <q-btn
                            v-if="step > 1"
                            @click="$refs.stepper.previous()"
                            padding="6px 16px"
                            rounded flat
                            label="Back"
                            icon="fas fa-chevron-left"
                            color="primary"
                            class="mr-20 tf-capitalize"
                        />
                        <!-- $refs.stepper.next(); doConsole($refs) -->
                        <q-btn
                            v-if="step !== 4"
                            @click="doCheckFormPerStepper($refs)"
                            padding="6px 16px"
                            rounded unelevated :class="['tf-capitalize']"
                            label="Next" icon-right="fas fa-chevron-right"
                            color="primary"
                        />
                        <q-btn
                            v-else
                            @click="doSubmitInsuranceForm()"
                            padding="6px 16px"
                            rounded unelevated :class="['tf-capitalize']"
                            type="submit" :loading="loader" label="Submit"
                            color="primary"
                        />
                    </div>
                </q-stepper-navigation>
            </template>
        </q-stepper>
    </q-page>
</template>

<script>
/* eslint-disable */
import Swal from 'sweetalert2'
import help from '../../js/help'
import Auth from '../../js/AuthValidation'
import { getVendorInsuranceByID, makeInsuranceClaimApi, makePathInsurance, updateInsurace } from '../../api/InsuranceService'

export default {
    data () {
        return{
            help,
            loader: false,
            step: 1,
            window: {
                width: 0,
                height: 0,
                heightAltered: 0
            },
            vendorInsurance: {},
            accessToken: null,
            errorMessage: false,
            vendorWorkshops: [],
            form: {
                vendorInsuranceID: null, // DONE
                userID: null, // DONE
                insuredName: null, // DONE
                phoneNumber: null, //  DONE
                email: null, // DONE
                addressClaimer: null, // DONE
                carTypeAndBrand: null, // DONE
                chassisNumber: null, // DONE
                polisNumber: null, // DONE
                licensePlateNumber: null, // DONE
                driverName: null, // DONE
                driverSpeed: null, // DONE
                driverLicense: null, // DONE
                driverRelation: null, // DONE
                incidentLocation: null, // DONE
                vehicleDescription: null, // DONE
                incidentDate: null, // DONE
                incidentTime: null, // DONE
                taxiOnlineStatus: null, // DONE
                isOnlineTaxi: false, // BUAT CHECKBOX
                isNotOnlineTaxi: false, // BUAT CHECKBOX
                incidentStatus: null, // DONE
                wasHit: false, // BUAT CHECKBOX
                wasNotHit: false, // BUAT CHECKBOX
                incidentStatusDescription: null, // DONE
                workshopTypeObj: {}, // DONE
                workshopType: null,
                workshopTypeID: null,
                chronology: null, // DONE
            },
            imageBinary: {},
            imageForm: [],
            rules: {
                //STEPPER 1
                insuredName_r: [
                    v => !!v || 'Name is required!'
                ],
                phoneNumber_r: [
                    v => !!v || 'Phone number is required!',
                    v => /^[0-9]{10,12}$/.test(v) || 'Minimal of 10 digit'
                ],
                email_r: [
                    v => !!v || 'Email is required!',
                    v => /^\w+([.+-]?\w+)*@\w+([.-]?\w+)*(\.\w{2,3})+$/.test(v) || 'Wrong email format'
                ],
                carTypeAndBrand_r: [
                    v => !!v || 'Brand dan Type is required!'
                ],
                chassisNumber_r: [
                    v => !!v || 'Chassis number is required!'
                    // v => /^[0-9][A-Z]{17,17}$/.test(v) || 'Wrong chassis number format'
                ],
                addressClaimer_r: [
                    v => !!v || 'Address is required!'
                ],
                polisNumber_r: [
                    v => !!v || 'Polis number is required!'
                ],
                licensePlateNumber_r: [
                    v => !!v || 'Registration number is required!'
                ],
                //STEPPER 2
                driverName_r: [
                    v => !!v || 'Driver\'s name is required!'
                ],
                driverLicense_r: [
                    v => !!v || 'Driver\'s license number is required!'
                ],
                driverRelation_r: [
                    v => !!v || 'Driver\'s relation is required!'
                ],
                driverSpeed_r: [
                    v => !!v || 'Driver\'s speed is required!'
                ],
                incidentLocation_r: [
                    v => !!v || 'Incident location is required!'
                ],
                vehicleDescription_r: [
                    v => !!v || 'Vehicle Description is required!'
                ],
                incidentDate_r: [
                    v => !!v || 'Incident date is required!'
                ],
                incidentTime_r: [
                    v => !!v || 'Incident time is required!'
                ],
                //STEPPER 3
                incidentStatusDescription_r: [
                    v => !!v || 'Incident status description is required!'
                ],
                chronology_r: [
                    v => !!v || 'Chronology is required!'
                ],
                emptyRule: []
            }
        }
    },
    created () {
        this.user = Auth.getUserDetails()
        this.accessToken = Auth.getAccessToken()
        this.vendorInsuranceID = this.$route.params.id
        this.userID = this.user.id
        this.doGetVendorInsuranceByID()
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
        },
        doGetVendorInsuranceByID () {
            let _this = this
            _this.loader = true
            let token = Auth.getAccessToken()
            getVendorInsuranceByID(_this.vendorInsuranceID, token).then(response => {
                _this.vendorInsurance = response.data.objectReturn
                _this.vendorWorkshops = []
                _this.vendorWorkshops = [{value: 0, label: 'Workshop of my own choice'}]
                console.log(_this.vendorInsurance)
                _this.addUploadPhoto(true)
            }) .catch((err) => {
                _this.loader = false
                console.log(err)
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
            } else {
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
                if(!help.isDataEmpty(item.name)){
                    item.imageFile = formData
                    this.imageBinary = {}
                    item.filePath = item.filePath !== 'null' ? item.filePath : 'null'
                    this.imageBinary = formData
                    this.getURLForImage(item, index)
                } else {
                    Swal.fire ({
                        icon: "warning",
                        title: "Warning!",
                        text: "Please input photo name first"
                    }) .then(() => {
                        item.imageFile = null
                        document.getElementById('uploadDPUser-' + index).value = ''
                    })
                }
            }
        },
        getURLForImage(item, index){
            let _this = this
            makePathInsurance(item.filePath, item.name, item.imageFile, _this.accessToken).then(response => {
                _this.imageForm[index].filePath = response.data.filePath
            }) .catch((error) => {
                console.log(error.response)
                Swal.fire ({
                    icon: "error",
                    title: "Upload image error"
                })
            })
        },
        addUploadPhoto (firstLoader) {
            if(firstLoader){
                for (let i = 0; i < 10; i++) {
                    const tempObj = {
                        name: '',
                        imageFile: null,
                        uploaded: false,
                        filePath: 'null'
                    }
                    this.imageForm.push(tempObj)
                }
                this.loader = false
            } else {
                const tempObj = {
                    name: '',
                    imageFile: null,
                    uploaded: false,
                    filePath: 'null'
                }
                this.imageForm.push(tempObj)
            }
        },
        doUploadPhotoDocumentInsurance () {
            let _this = this
            let tempObj = {
                insuranceID: _this.vendorInsurance.id,
                insuranceDocument: _this.imageForm
            }
            updateInsurace(tempObj, _this.accessToken).then(response => {
                if(response.data.message == 'Success') {
                    Swal.fire ({
                        icon: "success",
                        title: "Form Submitted",
                        text: "Your request is being processed"
                    }) .then (() => {
                        _this.changePage('/insurance/status-insurance')
                        _this.loader = false
                    })
                } else {
                    _this.loader = false
                    Swal.fire ({
                        icon: "error",
                        title: "Upload image error"
                    })
                }
                
            }) .catch((error) => {
                console.log(error.response)
                _this.loader = false
                Swal.fire ({
                    icon: "error",
                    title: "Please contact our admin"
                })
            })
        },
        doSubmitInsuranceForm () {
            let _this = this
            _this.loader = true
            _this.form.vendorInsuranceID = _this.vendorInsuranceID
            _this.form.userID = _this.userID
            _this.form.incidentDate = help.defaultFormat(_this.form.incidentDate, help.data().dmy_5)
            _this.form.workshopType = _this.form.workshopTypeObj.label
            _this.form.workshopTypeID = _this.form.workshopTypeObj.value
            if(!_this.form.isOnlineTaxi){
                _this.form.taxiOnlineStatus = 'no'
            } else {
                _this.form.taxiOnlineStatus = 'yes'
            }
            if(!_this.form.wasHit){
                _this.form.incidentStatus = 'no'
            } else {
                _this.form.incidentStatus = 'yes'
            }
            console.log(_this.form)
            makeInsuranceClaimApi(_this.user.id, _this.vendorInsuranceID, _this.form, _this.accessToken).then(response => {
                if(response.data.message == 'Success'){
                    _this.doUploadPhotoDocumentInsurance()
                } else {
                    _this.loader = false
                    Swal.fire ({
                        icon: "error",
                        title: "Form Error"
                    })
                }
                
            }) .catch((err) => {
                console.log(err.response)
                _this.loader = false
                _this.errorMessage = true
                Swal.fire ({
                    icon: "error",
                    title: "Form Error"
                })
            })
        },
        doCheckPhotoUploadedMin10Photo () {
            let bool = false
            _this.imageForm.forEach(el1 => {
                if(help.isDataEmpty(el1.name)){
                    bool = true
                }
            })
            if(bool){
                Swal.fire ({
                    icon: "warning",
                    title: "Warning Submit",
                    text: "Please fill all existing upload slot!"
                })
            } else {
                _this.doSubmitInsuranceForm()
            }
        },
        doCheckFormPerStepper(refs){
            // refs.stepper.next() // kalau mau ngilangin validasi ctrl + / di line ini vice versa
            if(this.step == 1 && this.$refs.formStepper1) {
                this.$refs.formStepper1.validate().then(success => {
                    if (success) {
                        refs.stepper.next()
                    }
                })
            } 
            else if (this.step == 2 && this.$refs.formStepper2) {
                this.$refs.formStepper2.validate().then(success => {
                    if (success) {
                        refs.stepper.next()  
                    }
                })
            }
            else if (this.step == 3 && this.$refs.formStepper3) {
                this.$refs.formStepper3.validate().then(success => {
                    console.log(this.form.workshopTypeObj)
                    if(!this.form.isOnlineTaxi && !this.form.isNotOnlineTaxi){
                        this.errorMessage = true
                    } else if (!this.form.wasNotHit && !this.form.wasHit) {
                        this.errorMessage = true
                    } else if (success) {
                        refs.stepper.next()
                    }
                })
            }
        },
        changePage(url){
            this.$router.push(url)
        },
        doConsole (a) {
            console.log(a)
        }
    }
}
</script>