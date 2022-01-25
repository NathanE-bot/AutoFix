<template>
    <q-page-container style="padding-top: 1.25rem;">
        <q-page class="w-90 m-auto fh p-20">
            <div class="white-1bg fh br-20px">
              <q-tabs
                v-model="initialTab"
                align="justify"
              >
                <q-tab name="editWorkshop" label="Edit Workshop" class="tf-capitalize"/>
                <q-tab name="editServices" label="Edit Services" class="tf-capitalize"/>
              </q-tabs>
              <q-separator/>
              <div class="col-12 j-end px-20 pt-10">
                <div v-if="isEditableWorkshop === false" style="height: 31px">
                  <i class="fas fa-pen fs-20 edit-icon" @click="isEditableWorkshop = !isEditableWorkshop"></i>
                  <q-tooltip class="bg-primary text-body2 txt-white" self="center right" :offset="[10, 15]">
                    Edit Profile
                  </q-tooltip>
                </div>
                <div v-else>
                  <q-btn
                    v-if="isEditableWorkshop"
                    @click="doUpdateProfile(true)" :loading="loader" unelevated rounded color="primary" label="Save Profile" class="tf-capitalize ml-20 fs-12"></q-btn>
                </div>
              </div>
              <div v-if="initialTab === 'editWorkshop'" class="col-md-12 p-20">
                <div class="row">
                  <div class="col-md-3">
                    <div :class="['no-logo-layout-4 m-auto', { 'm-auto' : help.isDataEmpty(this.dataWorkshop.workshopLogo) && loader === false }]">
                      <img  v-if="!help.isDataEmpty(this.dataWorkshop.workshopLogo)" class="m-auto" src="https://cdn.quasar.dev/img/mountains.jpg" alt="">
                      <span>No Logo</span>
                    </div>
                  </div>
                  <div class="col-md-3 px-10 q-col-gutter-y-sm">
                    <div class="fs-12">
                      <span class="">Workshop Name :</span>
                      <q-input  v-model="this.dataWorkshop.workshopName" dense outlined :disable="isEditableWorkshop === false"/>
                    </div>
                    <div class="fs-12">
                      <span class="">Workshop Email :</span>
                      <q-input v-model="this.dataWorkshop.workshopEmail" dense outlined disable/>
                    </div>
                    <div class="fs-12">
                      <span class="">Workshop Phone Number :</span>
                      <q-input v-model="this.dataWorkshop.workshopPhoneNumber" dense outlined :disable="isEditableWorkshop === false"/>
                    </div>
                  </div>
                  <div class="col-md-3 px-10 q-col-gutter-y-sm">
                    <div class="fs-12">
                      <span class="">District :</span>
                      <q-input  v-model="this.dataWorkshop.district" dense outlined :disable="isEditableWorkshop === false"/>
                    </div>
                    <div class="fs-12">
                      <span class="">City :</span>
                      <q-input v-model="this.dataWorkshop.city" dense outlined :disable="isEditableWorkshop === false"/>
                    </div>
                    <div class="fs-12">
                      <span class="">Province :</span>
                      <q-input v-model="this.dataWorkshop.province" dense outlined :disable="isEditableWorkshop === false"/>
                    </div>
                  </div>
                  <div class="col-md-3 px-10 q-col-gutter-y-sm">
                    <div class="fs-12">
                      <span class="">Latitude :</span>
                      <q-input v-model="this.dataWorkshop.latitude" dense outlined :disable="isEditableWorkshop === false"/>
                    </div>
                    <div class="fs-12">
                      <span class="">Longitude :</span>
                      <q-input v-model="this.dataWorkshop.longitude" dense outlined :disable="isEditableWorkshop === false"/>
                    </div>
                  </div>
                </div>
                <br/>
                <div class="row">
                  <div class="col-md-6 pr-10">
                    <div class="fs-12">
                      <span class="">Workshop Address :</span>
                      <q-input autogrow maxlength="300" class="ta-r-none-200" v-model="this.dataWorkshop.workshopAddress" outlined type="textarea" :disable="isEditableWorkshop === false"/>
                    </div>
                  </div>
                  <div class="col-md-6 pl-10">
                    <div class="fs-12">
                      <span class="">Workshop Description :</span>
                      <q-input autogrow maxlength="300" class="ta-r-none-200" v-model="this.dataWorkshop.workshopDescription" outlined type="textarea" :disable="isEditableWorkshop === false"/>
                    </div>
                  </div>
                </div>
              </div>
              <div v-if="initialTab === 'editServices'" class="col-md-12">
                <div class="row">
                  <div class="col-md-4 p-20">
                    <div>
                      select model
                    </div>
                    <div>
                      select type berdasarkan model
                    </div>
                  </div>
                  <q-separator vertical/>
                  <div class="col-md-8">

                  </div>
                </div>
              </div>
            </div>
        </q-page>
    </q-page-container>
</template>

<script>
import { getWorkshopDetailByUserID, doUpdateWorkshopForAdminBengkel } from '../../../api/AdminWorkshopServices'
import { LocalStorage } from 'quasar'
import help from '../../../js/help'

export default {
  data () {
    return {
      loader: false,
      help,
      user: {},
      tempUser: {},
      initialTab: 'editWorkshop',
      dataWorkshop: {},
      isEditableWorkshop: false
    }
  },
  created () {
    this.user = LocalStorage.getItem('autoRepairUser').data.user
    console.log('this.user', this.user)
    this.doGetWorkshopDetailByUserID()
  },
  methods: {
    doGetWorkshopDetailByUserID () {
      this.loader = true
      getWorkshopDetailByUserID(this.user.id).then(response => {
        console.log('response', response)
        this.dataWorkshop = response.data
        this.dataWorkshop.workshopID = this.dataWorkshop.id
        delete this.dataWorkshop.id
        this.doUpdateProfile(false)
      }).finally(() => {
        this.loader = false
      })
    },
    doUpdateProfile (update) {
      if (!update) {
        this.tempUser = this.user
        console.log('masuk firstload pak eko')
      } else {
        console.log('yeet', this.dataWorkshop)
        doUpdateWorkshopForAdminBengkel(this.dataWorkshop).then(response => {
          console.log('response', response)
        })
        console.log('ngapdeeeeeeeet')
      }
      console.log('njay')
      this.isEditableWorkshop = false
    }
  }
}
</script>
