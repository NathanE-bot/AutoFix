<template>
  <q-page>
    <div class="screen-for-print white-1bg p-35 mt-0 fs-12">
      <div class="top j-sp-between noprint">
        <img class="logo-img" src="../../../assets/images/logo.png" alt="">
        <div>Icon Download</div>
      </div>
      <br class="noprint"/>
      <q-separator class="col-12" height="10px"/>
      <br class="noprint"/>
      <div class="kop-surat row">
        <q-img
          :src="insuranceData.logo"
          class="col-3 insurrance-logo-img"/>
        <div class="col-9 flex flex-center">
          Data Perusahaan
        </div>
      </div>
      <q-separator class="col-12" height="5px" color="black"/>
      <br/>
      <div class="col-12 a-end flex-dir-col">
        <div class="insurance_layout_txt-100 ">
          <div>
            <span>Submit Date</span>
            <span>:</span>
          </div>
          <span>{{ help.defaultFormat(insuranceData.submitDate, help.data().dmy_8) }}</span>
        </div>
        <div class="insurance_layout_txt-100">
          <div>
            <span>Approved Date</span>
            <span>:</span>
          </div>
          <span>{{ help.defaultFormat(insuranceData.claimedInsuranceDate, help.data().dmy_8) }}</span>
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
        <div class="row col-12 mt-20">
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
        <div class="col-6 d-flex flex-dir-col print-img a-center" v-for="photo in this.listPhoto" :key="photo.id">
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
  </q-page>
</template>

<script>
/* eslint-disable */
import { getAdminInsuranceDetails } from '../../../api/AdminInsuranceServices'
import help from '../../../js/help'

export default {
    data () {
      return {
        help,
        user: {},
        id: null,
        loader: false,
        insuranceData: {},
        listPhoto: []
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
        getAdminInsuranceDetails(1).then( response => {
          this.insuranceData = response.data.objectReturnerDataDetail[0]
          this.listPhoto = response.data.objectReturnerDocumentation
          console.log(this.listPhoto)
        })
      }
    }
}
</script>