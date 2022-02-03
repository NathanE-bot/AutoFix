<template>
  <q-page>
    <div class="screen-for-print white-1bg p-35 mt-0 fs-12">
      <div class="top j-sp-between noprint a-center">
        <q-img class="logo-img" src="../../../assets/images/logo.png" alt=""/>
        <div class="text-align-center">
          <div @click="doWindowPrint()" class="cursor-pointer">
            <i class="fas fa-download "></i>
            Download PDF
          </div>
          <br/>
          <div v-if="insuranceData.insuranceStatus === 'on progress'">
            <q-btn
              unelevated rounded color="negative"
              class="fs-12 tf-capitalize mr-5 px-21"
              label="Reject"
              @click="promptReject = true; rejectDescription = null; "
            />
            <q-btn
              unelevated rounded color="primary"
              class="fs-12 tf-capitalize ml-5"
              label="Approve"
              @click="promptApprove = true"
            />
          </div>
        </div>
      </div>
      <br class="noprint"/>
      <q-separator class="col-12 noprint" height="10px"/>
      <br class="noprint"/>
      <div class="kop-surat row">
        <q-img
          :src="insuranceData.logo"
          class="col-3 insurrance-logo-img"/>
        <div class="col-9">
          <div class="text-align-right">
            <div class="tf-capitalize text-h6 fw-semibold">{{ insuranceData.insuranceName }}</div>
            <div>{{ insuranceData.address }}</div>
            <div>{{ insuranceData.email }}</div>
          </div>
        </div>
      </div>
      <br/>
      <q-separator class="col-12" height="5px" color="black"/>
      <br/>
      <div class="col-12 a-end flex-dir-col">
        <div class="text-align-left">
          <div class="insurance_layout_txt-110 ">
            <div>
              <span>Submit Date</span>
              <span>:</span>
            </div>
            <span>{{ help.defaultFormat(insuranceData.submitDate, help.data().dmy_8) }}</span>
          </div>
          <div v-if="insuranceData.insuranceStatus !== 'on progress'" class="insurance_layout_txt-110">
            <div>
              <span>{{ insuranceData.insuranceStatus === 'Approved' ? 'Approved Date' : 'Rejected Date' }}</span>
              <span>:</span>
            </div>
            <span>{{ help.defaultFormat(insuranceData.claimedInsuranceDate, help.data().dmy_8) }}</span>
          </div>
          <div v-else style="height: 26px;"/>
        </div>
      </div>
      <div class="row">
        <div class="col-12 my-15">
          <span class="fs-18 fw-semibold">Insured Data</span>
        </div>
        <div class="col-6 q-gutter-y-md">
          <div class="insurance_layout_txt-100">
            <div>
              <span>Insured Name</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.insuredName }}</span>
          </div>
          <div class="insurance_layout_txt-100">
            <div>
              <span>Phone Number</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.phoneNumberClaimer }}</span>
          </div>
          <div class="insurance_layout_txt-100">
            <div>
              <span>Polis Number</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.polisNumber }}</span>
          </div>
        </div>
        <div class="col-6 q-gutter-y-md">
          <div class="insurance_layout_txt-150">
            <div>
              <span>Car Type and Brand</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.carTypeAndBrand }}</span>
          </div>
          <div class="insurance_layout_txt-150">
            <div>
              <span>Registration Number</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.licensePlateNumber }}</span>
          </div>
          <div class="insurance_layout_txt-150">
            <div>
              <span>Chassis Number</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.chassisNumber }}</span>
          </div>
        </div>
        <div class="row mt-20 flex flex-dir-col">
          <div class="insurance_layout_txt-100">
            <div>
              <span>Email Address</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.emailClaimer }}</span>
          </div>
          <div class="insurance_layout_txt-100 mt-5">
            <div>
              <span>Address</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.addressClaimer }}</span>
          </div>
        </div>
      </div>
      <br/>
      <q-separator class="col-12" height="5px"/>
      <div class="row">
        <div class="col-12 my-15">
          <span class="fs-18 fw-semibold">Incident Data</span>
        </div>
        <div class="col-6 q-gutter-y-md">
          <div class="insurance_layout_txt-100">
            <div>
              <span>Driver Name</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.driverName }}</span>
          </div>
          <div class="insurance_layout_txt-100">
            <div>
              <span>Driver License</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.driverLicense }}</span>
          </div>
          <div class="insurance_layout_txt-100">
            <div>
              <span>Driver Speed</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.driverSpeed }} Km/h</span>
          </div>
        </div>
        <div class="col-6 q-gutter-y-md">
          <div class="insurance_layout_txt-150">
            <div>
              <span>Incident Date</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.incidentDate }}</span>
          </div>
          <div class="insurance_layout_txt-150">
            <div>
              <span>Incident Time</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.incidentTime }}</span>
          </div>
          <div class="insurance_layout_txt-150">
            <div>
              <span>Relation with the insured</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.driverRelation }}</span>
          </div>
          <div class="insurance_layout_txt-150">
            <div>
              <span>Vehicle Used For</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.vehicleDescription }}</span>
          </div>
        </div>
        <div class="row col-12 mt-20">
          <div class="insurance_layout_txt-100">
            <div>
              <span>Incident Location</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.incidentLocation }}</span>
          </div>
        </div>
      </div>
      <br/>
      <q-separator class="col-12" height="5px"/>
      <div class="row">
        <div class="col-12 my-10">
          <span class="fs-18 fw-semibold">Detail Data</span>
        </div>
        <div class="col-6 q-gutter-y-md">
          <div class="insurance_layout_txt-125">
            <div>
              <span>Bengkel Name</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.workshopType }}</span>
          </div>
          <div class="insurance_layout_txt-125">
            <div>
              <span>Taxi Online Status</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.taxiOnlineStatus }}</span>
          </div>
          <div class="insurance_layout_txt-125">
            <div>
              <span>Incident Status</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.incidentStatus }}</span>
          </div>
        </div>
        <div class="row col-12 mt-20">
          <div v-if="insuranceData.incidentStatus === 'Yes'" class="insurance_layout_txt-125">
            <div>
              <span>Incident Status Desc</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.incidentStatusDescription }}</span>
          </div>
          <div class="insurance_layout_txt-125 mt-15 a-start">
            <div>
              <span>Chronology</span>
              <span>:</span>
            </div>
            <span>{{ insuranceData.chronology }}</span>
          </div>
        </div>
      </div>
      <!-- PAGE 2 FOR PICTURE -->
      <div class="mt-100 fs-18 fw-bold">LAMPIRAN</div>
      <div class="row mt-20">
        <div class="col-6 d-flex flex-dir-col print-img a-center" @click="doZoomPhoto(photo)" v-for="photo in this.listPhoto" :key="photo.id">
          <q-img
            :src="photo.documentationPicture"
            class="responsive_img"
            :ratio="1"
            style="width: 300px; height: 300px"
          />
          <span>{{ photo.documentationInsuranceName }}</span>
        </div>
      </div>
    </div>
    <q-dialog v-model="promptZoomPhoto">
      <q-card style="width: 500px;">
        <q-img :src="zoomPhoto.documentationPicture">
          <div class="absolute-bottom text-subtitle2 text-center">
            {{ zoomPhoto.documentationInsuranceName }}
          </div>
        </q-img>
      </q-card>
    </q-dialog>
    <q-dialog v-model="promptApprove">
        <q-card style="min-width: 480px" class="py-20 br-10px-i" >
            <form @submit.prevent="submit">
              <q-card-section>
                <div class="j-center br-20px" style="border: 1px solid;margin: auto;width: 300px;height: 150px;">
                  <div class="flex flex-center flex-dir-col" style="gap: 1rem">
                    <i v-if="filePDF === null" class="fas fa-cloud-upload-alt fs-40" style="width:50px; height: 50px"/>
                    <span v-else class="line-clamp-3">{{ filePDF.name }}</span>
                    <div class="container-upload ">
                        <input class="cursor-pointer" style="color: transparent; width:92px" type="file" @change="onChange" :id="'UploadPDF'">
                    </div>
                  </div>
                </div>
              </q-card-section>

              <q-card-actions align="center" class="text-primary">
                  <q-btn padding="4px 24px" rounded unelevated label="Cancel" v-close-popup class="tf-capitalize"/>
                  <q-btn padding="4px 20px" rounded unelevated color="primary" label="Approve" class="tf-capitalize" type="submit" v-close-popup/>
              </q-card-actions>
            </form>
        </q-card>
    </q-dialog>
    <q-dialog v-model="promptReject">
        <q-card class="fw m-auto" >
            <q-card-section>
                <div class="black-1 m-auto fw-semibold text-align-center">Insert rejecting reason</div>
            </q-card-section>
            <div class="fw m-auto">
              <q-input
                outlined
                type="textarea"
                class="fix-txt-field default-textarea-1 w-80 m-auto"
                v-model="rejectDescription"
              >
              </q-input>
            </div>
            <q-card-actions align="center" class="text-primary">
                <q-btn padding="4px 24px" rounded unelevated label="Cancel" v-close-popup class="tf-capitalize"  @click="promptDetail = true"/>
                <q-btn padding="4px 20px" rounded unelevated color="negative" label="Reject" class="tf-capitalize" v-close-popup @click="doRejectClaim()"/>
            </q-card-actions>
        </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
/* eslint-disable */
import { getAdminInsuranceDetails, acceptInsuranceClaim, uploadPDFInsurance, rejectInsuranceClaim } from '../../../api/AdminInsuranceServices'
import help from '../../../js/help'
import Swal from 'sweetalert2'

export default {
    data () {
      return {
        help,
        user: {},
        id: null,
        loader: false,
        insuranceData: {},
        listPhoto: [],
        zoomPhoto: {},
        promptZoomPhoto: false,
        promptApprove: false,
        promptReject: false,
        rejectDescription: null,
        dataUpload: {},
        filePDF: null
      }
    },
    created() {
      this.id = this.$route.params.insuranceID
      console.log('id', this.id)
      this.doGetAdminInsuranceDetails(this.$route.params.insuranceID)
    },
    methods: {
      changePage (url) {
        this.$router.push(url)
      },
      doGetAdminInsuranceDetails(insuranceID) {
        this.loader = true
        getAdminInsuranceDetails(insuranceID).then( response => {
          this.insuranceData = response.data.objectReturnerDataDetail[0]
          this.listPhoto = response.data.objectReturnerDocumentation
          console.log(this.insuranceData)
        })
      },
      doWindowPrint(){
        window.print()
      },
      doZoomPhoto(photoPath){
        this.zoomPhoto = {}
        this.zoomPhoto = photoPath
        this.promptZoomPhoto = true
        console.log(this.zoomPhoto)
      },
      doRejectClaim(){
        this.loader = true
        rejectInsuranceClaim(this.$route.params.insuranceID, this.rejectDescription)
        .then(response => {
          console.log(response)
          Swal.fire ({
            icon: "success",
            title: "Success",
            text: "Reject claim successfully"
          }) .then(() => {
            this.changePage('/admin/insurance/incoming-claim-request')
          })
        }).catch(err => {
          Swal.fire ({
            icon: "success",
            title: "Upload Success",
            text: "Please contact our admin"
          })
            console.log(err)
        })
          this.promptReject = false
          this.loader = false
      },
      doAcceptClaim(){
        this.loader = true
        acceptInsuranceClaim(this.$route.params.insuranceID)
        .then(response => {
          console.log(response)
        })
      },
      onChange(e) {
        if(!help.isValidFilePDF(e.target.files[0].type)){
          this.promptApprove = false;
          Swal.fire ({
              icon: "error",
              title: "Input Error",
              text: "File type is not .pdf"
          })
          document.getElementById('UploadPDF').value = ''
        }else{
          this.filePDF = e.target.files[0]
          console.log(this.filePDF)
        }
      },
      submit() {
        this.loader = true
        let fd = new FormData();
        fd.append('filePDF', this.filePDF)

        uploadPDFInsurance(this.$route.params.insuranceID, fd)
        .then(response => {
          this.doAcceptClaim(this.$route.params.insuranceID)
        }).finally(() => {
          this.doGetAdminInsuranceDetails(this.$route.params.insuranceID)
          this.loader = false
        })
        .catch(err => {
          Swal.fire ({
              icon: "error",
              title: "Input Error",
              text: "Please contact our admin" //revisi
          })
        })
      }
    }
}
</script>