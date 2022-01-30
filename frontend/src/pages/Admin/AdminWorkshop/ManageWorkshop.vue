<template>
  <q-page class="w-90 m-auto p-20">
    <div class="white-1bg fh br-20px">
      <q-tabs
        v-model="initialTab"
        align="justify"
      >
        <q-tab name="editWorkshop" label="Edit Workshop" class="tf-capitalize"/>
        <q-tab name="editServices" label="Edit Services" class="tf-capitalize"/>
      </q-tabs>
      <q-separator/>
      <div v-if="initialTab === 'editWorkshop'" class="col-md-12 p-20">
        <div class="row j-end px-20 pt-10">
          <div v-if="isEditableWorkshop === false" style="height: 31px">
            <i class="fas fa-pen fs-20 edit-icon" @click="isEditableWorkshop = !isEditableWorkshop"></i>
            <q-tooltip class="bg-primary text-body2 txt-white" self="center right" :offset="[10, 15]">
              Edit Profile
            </q-tooltip>
          </div>
          <div v-else>
            <q-btn
              v-if="isEditableWorkshop"
              @click="isEditableWorkshop = !isEditableWorkshop" :loading="loader" unelevated rounded color="negative" label="Cancel Edit" class="tf-capitalize ml-20 fs-12"/>
            <q-btn
              v-if="isEditableWorkshop"
              :loading="loader" unelevated rounded color="primary" label="Save Profile" class="tf-capitalize ml-20 fs-12"/>
          </div>
        </div>
        <div class="row">
          <div class="col-md-3">
            <div :class="['no-logo-layout-4 m-auto', { 'm-auto' : help.isDataEmpty(this.workshopDetail.workshopLogo) && loader === false }]">
              <img  v-if="!help.isDataEmpty(this.workshopDetail.workshopLogo)" class="m-auto" src="https://cdn.quasar.dev/img/mountains.jpg" alt="">
              <span>No Logo</span>
            </div>
          </div>
          <div class="col-md-3 px-10 q-col-gutter-y-sm">
            <div class="fs-12">
              <span class="">Workshop Name :</span>
              <q-input  v-model="this.workshopDetail.workshopName" dense outlined :disable="isEditableWorkshop === false"/>
            </div>
            <div class="fs-12">
              <span class="">Workshop Email :</span>
              <q-input v-model="this.workshopDetail.workshopEmail" dense outlined :disable="isEditableWorkshop === false" />
            </div>
            <div class="fs-12">
              <span class="">Workshop Phone Number :</span>
              <q-input v-model="this.workshopDetail.workshopPhoneNumber" dense outlined :disable="isEditableWorkshop === false"/>
            </div>
          </div>
          <div class="col-md-3 px-10 q-col-gutter-y-sm">
            <div class="fs-12">
              <span class="">District :</span>
              <q-input  v-model="this.workshopDetail.district" dense outlined :disable="isEditableWorkshop === false"/>
            </div>
            <div class="fs-12">
              <span class="">City :</span>
              <q-input v-model="this.workshopDetail.city" dense outlined :disable="isEditableWorkshop === false"/>
            </div>
            <div class="fs-12">
              <span class="">Province :</span>
              <q-input v-model="this.workshopDetail.province" dense outlined :disable="isEditableWorkshop === false"/>
            </div>
          </div>
          <div class="col-md-3 px-10 q-col-gutter-y-sm">
            <div class="fs-12">
              <span class="">Latitude :</span>
              <q-input v-model="this.workshopDetail.latitude" dense outlined :disable="isEditableWorkshop === false"/>
            </div>
            <div class="fs-12">
              <span class="">Longitude :</span>
              <q-input v-model="this.workshopDetail.longitude" dense outlined :disable="isEditableWorkshop === false"/>
            </div>
          </div>
        </div>
        <br/>
        <div class="row">
          <div class="col-md-6 pr-10">
            <div class="fs-12">
              <span class="">Workshop Address :</span>
              <q-input autogrow maxlength="300" class="ta-r-none-200" v-model="this.workshopDetail.workshopAddress" outlined type="textarea" :disable="isEditableWorkshop === false"/>
            </div>
          </div>
          <div class="col-md-6 pl-10">
            <div class="fs-12">
              <span class="">Workshop Description :</span>
              <q-input autogrow maxlength="300" class="ta-r-none-200" v-model="this.workshopDetail.workshopDescription" outlined type="textarea" :disable="isEditableWorkshop === false"/>
            </div>
          </div>
        </div>
      </div>
      <div v-if="initialTab === 'editServices'" class="col-md-12">
        <div class="row">
          <div class="col-md-4 p-20">
            <div class="col-12 j-end">
              <q-btn
                @click="doFilterCarModelAndType(true)"
                icon="fas fa-pen" flat round
                class="edit-pen-btn edit-pen-btn-active"
              >
                <q-tooltip
                  class="text-body2 txt-white bg-primary"
                  anchor="center left" self="center end" :offset="[10, 0]">
                  Edit Car Model & Type
                </q-tooltip>
              </q-btn>
            </div>
            <br/>
            <q-select
              @update:model-value="doFilterCarType($event)"
              v-model="jsonDataParam.carModel"
              :options="carModelOptions"
              outlined
              class="br-10px default-select-2 w-80 mx-auto mb-20"
            >
              <template v-slot:selected>
                <template v-if="jsonDataParam.carModel">
                  {{ jsonDataParam.carModel }}
                </template>
                <template v-else>
                  <span class="placeholder-text">Choose Car Model...</span>
                </template>
              </template>
            </q-select>
            <q-select
              @update:model-value="doGetCarServices($event)"
              v-model="jsonDataParam.carType"
              :options="carTypeOptions"
              outlined
              class="br-10px default-select-2 w-80 mx-auto mb-20"
            >
              <template v-slot:selected>
                <template v-if="jsonDataParam.carType">
                  {{ jsonDataParam.carType }}
                </template>
                <template v-else>
                  <span class="placeholder-text">Choose Car Type...</span>
                </template>
              </template>
              <template v-slot:no-option>
                <q-item>
                  <q-item-section class="text-grey">
                    Please choose car model first.
                  </q-item-section>
                </q-item>
              </template>
            </q-select>
          </div>
          <q-separator vertical size="1px" />
          <div class="col-md-7 p-20">
            <div class="col-12 j-end d-flex a-center">
              <q-btn
                @click="!help.isDataEmpty(jsonDataParam.carType) ? doFilterCarServices(true) : doNothing()"
                icon="fas fa-pen" flat round
                :class="['edit-pen-btn', {'edit-pen-btn-active' : !help.isDataEmpty(jsonDataParam.carType)}]"
              >
                <q-tooltip
                  :class="['text-body2 txt-white', {'bg-info' : help.isDataEmpty(jsonDataParam.carType)}, {'bg-primary' : !help.isDataEmpty(jsonDataParam.carType)}]"
                  anchor="center left" self="center end" :offset="[10, 0]">
                  <q-icon v-if="help.isDataEmpty(jsonDataParam.carType)" name="fas fa-info-circle" />
                  {{ help.isDataEmpty(jsonDataParam.carType) ? 'Choose car model and type first' : 'Edit Periodic & General Services' }}
                </q-tooltip>
              </q-btn>
            </div>
            <br/>
            <div class="row">
              <q-checkbox v-model="periodic" :disable="help.isDataEmpty(jsonDataParam.carType)" color="secondary" label="Periodic Services" :class="['fw-lightbold fs-20']">
                <q-tooltip transition-show="scale" transition-hide="scale" v-if="help.isDataEmpty(jsonDataParam.carType)">
                  Choose car model and type first
                </q-tooltip>
              </q-checkbox>
              <div class="row col-12 ml-40 mt-10 gap-1" v-if="periodic && periodicServicesOptions">
                <div class="auto-3" v-for="(service, index) in periodicServicesOptions" :key="'periodic-' + index">
                  <span>{{ service.serviceDetail }} - Rp {{ ValidationFunction.convertToRupiah(service.price) }}</span>
                </div>
              </div>
              <div class="row col-12 ml-40 mt-10 gap-1" v-else-if="periodic && help.isObjectEmpty(periodicServicesOptions)">
                No periodic service listed
              </div>
            </div>
            <br/>
            <div class="row">
              <q-checkbox v-model="general" :disable="help.isDataEmpty(jsonDataParam.carType)" color="secondary" label="General Services" :class="['fw-lightbold fs-20']">
                <q-tooltip transition-show="scale" transition-hide="scale" v-if="help.isDataEmpty(jsonDataParam.carType)">
                  Choose car model and type first
                </q-tooltip>
              </q-checkbox>
              <div class="row col-12 ml-40 mt-10 gap-1" v-if="general && !help.isObjectEmpty(generalServicesOptions)">
                <div class="auto-3" v-for="(service, index) in generalServicesOptions" :key="'general-' + index">
                  <span>{{ service.serviceDetail }} - Rp {{ ValidationFunction.convertToRupiah(service.price) }}</span>
                </div>
              </div>
              <div class="row col-12 ml-40 mt-10 gap-1" v-else-if="general && help.isObjectEmpty(generalServicesOptions)">
                No general service listed
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <q-dialog v-model="dialogEditCarTypeAndModel" persistent class="edit-car-typemodel-dialog">
      <q-card>
        <q-card-section class="p-0">
          <q-table
            class="edit-car-spec-table"
            virtual-scroll binary-state-sort hide-pagination
            :columns="cmth"
            :rows="carModelAndType"
            row-key="index"
            :rows-per-page-options="[0]"
          >
            <template v-slot:body="props">
              <q-tr v-if="help.isDataEmpty(props.row.id) && props.row.id !== '#1'" class="vertical-top">
                <q-td key="index" :props="props">
                  <div class="d-flex a-center j-start ml-10" style="min-height:40px">
                    <span class="fw-semibold">{{ props.row.index + 1 }}</span>
                    <q-btn
                      v-if="carModelAndType.length > 1"
                      :disabled="carModelAndType.length == 1 && props.row.index == 0"
                      @click="deleteCarModelAndType(props.row.index, props.row)"
                      label="Remove" flat rounded color="negative"
                      class="tf-capitalize ml-5"
                    />
                  </div>
                </q-td>
                <q-td key="carmodel" :props="props">
                  <q-input class="input-bold" dense readonly borderless v-model="props.row.carModel" />
                </q-td>
                <q-td key="cartype" :props="props">
                  <div class="row" v-for="(item, index) in props.row.carType" :key="'asd1' + index">
                    <q-input class="col-9 w-71-i" :error="help.isDataEmpty(item.name) && showError" dense hide-bottom-space v-model="item.name"/>
                    <div class="col row a-center">
                      <q-btn
                        v-if="props.row.carType.length > 1"
                        @click="deleteCarTypeForm(props.row.index, index, true)"
                        icon="fas fa-trash" size="sm"
                        flat round color="negative"
                      />
                      <q-btn
                        v-if="index == props.row.carType.length - 1"
                        @click="doAddNewCarType(props.row.index, true)"
                        icon="fas fa-plus" size="sm"
                        flat round color="primary"
                      />
                    </div>
                  </div>
                </q-td>
              </q-tr>
              <q-tr v-else class="vertical-top">
                <q-td key="index" :props="props">
                  <div class="d-flex a-center j-start ml-10" style="min-height:40px">
                    {{ props.row.index + 1 }}
                    <q-btn
                      @click="deleteCarModelAndType(props.row.index, props.row)"
                      label="Remove" flat rounded color="negative"
                      class="tf-capitalize ml-5"
                    />
                  </div>
                </q-td>
                <q-td key="carmodel" :props="props">
                  <q-input dense :error="help.isDataEmpty(props.row.carModel) && showError" hide-bottom-space v-model="props.row.carModel"/>
                </q-td>
                <q-td key="cartype" :props="props" class="text-left">
                  <div class="row" v-for="(item, index) in props.row.carType" :key="'asd2' + index">
                    <q-input class="col-9 w-71-i" :error="help.isDataEmpty(item.name) && showError" hide-bottom-space dense v-model="item.name" />
                    <div class="col row a-center">
                      <q-btn
                        v-if="props.row.carType.length > 1"
                        @click="deleteCarTypeForm(props.row.index, index)"
                        icon="fas fa-trash" size="sm"
                        flat round color="negative"
                      />
                      <q-btn
                        v-if="index == props.row.carType.length - 1"
                        @click="doAddNewCarType(props.row.index, false)"
                        icon="fas fa-plus" size="sm"
                        flat round color="primary"
                      />
                    </div>
                  </div>
                </q-td>
              </q-tr>
            </template>
          </q-table>
        </q-card-section>
        <q-card-actions align="right" class="p-20 d-flex a-center j-sp-between relative-position">
          <div>
            <q-btn
              class="tf-capitalize icon-resize"
              color="primary" icon="fas fa-plus"
              rounded label="New car specification"
              @click="doAddNewCarModelAndType()"
            />
          </div>
          <!-- <q-pagination
            v-model="jsonDataParamTable.iPage"
            color="primary"
            :max="jsonDataParamTable.maxPage"
            size="md"
          /> -->
          <div class="q-gutter-x-sm">
            <q-btn class="tf-capitalize" color="primary" flat rounded label="Close" @click="dialogEditCarTypeAndModel = false; carModelAndType = []"/>
            <q-btn class="tf-capitalize" color="primary" rounded label="Submit" @click="doUpdateCarModelAndType()"/>
          </div>
        </q-card-actions>
      </q-card>
    </q-dialog>
    <q-dialog full-width v-model="dialogEditCarServices" persistent class="edit-car-services-dialog">
      <q-card class="flex column j-sp-between">
        <q-card-section class="p-0 row">
          <q-table
            class="edit-car-services-table col-6 px-12"
            title="Periodic Services"
            virtual-scroll binary-state-sort hide-pagination
            :columns="csh"
            :rows="periodicServicesForms"
            row-key="index"
            :rows-per-page-options="[0]"
          >
            <template v-slot:body="props">
              <q-tr v-if="help.isDataEmpty(props.row.id) && props.row.id !== '#1'" class="vertical-top">
                <q-td key="index" :props="props">
                  <div class="d-flex a-center j-start ml-10" style="min-height:40px">
                    <span class="fw-semibold">{{ props.row.index + 1 }}</span>
                  </div>
                </q-td>
                <q-td key="servicedetail" :props="props">
                  <q-input class="input-bold" dense :error="help.isDataEmpty(props.row.serviceDetail) && showError" hide-bottom-space v-model="props.row.serviceDetail" />
                </q-td>
                <q-td key="price" :props="props">
                  <q-input class="input-bold" dense :error="help.isDataEmpty(props.row.price) && showError" hide-bottom-space v-model="props.row.price" />
                </q-td>
                <q-td key="time" :props="props">
                  <q-input class="input-bold" placeholder="1 - 10" suffix="Hour" dense :error="help.isDataEmpty(props.row.time) && showError" hide-bottom-space v-model="props.row.time" />
                </q-td>
                <q-td key="action" :props="props">
                  <q-btn
                    @click="doDeleteWorkshopServices(props.row, props.row.index)"
                    label="Remove" flat rounded color="negative"
                    class="tf-capitalize"
                  />
                </q-td>
              </q-tr>
              <q-tr v-else class="vertical-top">
                <q-td key="index" :props="props">
                  <div class="d-flex a-center j-start ml-10" style="min-height:40px">
                    <span>{{ props.row.index + 1 }}</span>
                  </div>
                </q-td>
                <q-td key="servicedetail" :props="props">
                  <q-input dense :error="help.isDataEmpty(props.row.serviceDetail) && showError" hide-bottom-space v-model="props.row.serviceDetail" />
                </q-td>
                <q-td key="price" :props="props">
                  <q-input dense :error="help.isDataEmpty(props.row.price) && showError" hide-bottom-space v-model="props.row.price" />
                </q-td>
                <q-td key="time" :props="props">
                  <q-input dense placeholder="1 - 10" suffix="Hour" :error="help.isDataEmpty(props.row.time) && showError" hide-bottom-space v-model="props.row.time" />
                </q-td>
                <q-td key="action" :props="props">
                  <q-btn
                    @click="doDeleteWorkshopServices(props.row, props.row.index)"
                    label="Remove" flat rounded color="negative"
                    class="tf-capitalize col"
                  />
                </q-td>
              </q-tr>
            </template>
          </q-table>
          <q-table
            class="edit-car-services-table col-6 px-12"
            title="General Services"
            virtual-scroll binary-state-sort hide-pagination
            :columns="csh"
            :rows="generalServicesForms"
            row-key="index"
            :rows-per-page-options="[0]"
          >
            <template v-slot:body="props">
              <q-tr v-if="help.isDataEmpty(props.row.id) && props.row.id !== '#1'" class="vertical-top">
                <q-td key="index" :props="props">
                  <div class="d-flex a-center j-start ml-10" style="min-height:40px">
                    <span class="fw-semibold">{{ props.row.index + 1 }}</span>
                  </div>
                </q-td>
                <q-td key="servicedetail" :props="props">
                  <q-input class="input-bold" dense :error="help.isDataEmpty(props.row.serviceDetail) && showError" hide-bottom-space v-model="props.row.serviceDetail" />
                </q-td>
                <q-td key="price" :props="props">
                  <q-input class="input-bold" dense :error="help.isDataEmpty(props.row.price) && showError" hide-bottom-space v-model="props.row.price" />
                </q-td>
                <q-td key="time" :props="props">
                  <q-input class="input-bold" placeholder="1 - 10" suffix="Hour" dense :error="help.isDataEmpty(props.row.time) && showError" hide-bottom-space v-model="props.row.time" />
                </q-td>
                <q-td key="action" :props="props">
                  <q-btn
                    @click="doDeleteWorkshopServices(props.row, props.row.index)"
                    label="Remove" flat rounded color="negative"
                    class="tf-capitalize"
                  />
                </q-td>
              </q-tr>
              <q-tr v-else class="vertical-top">
                <q-td key="index" :props="props">
                  <div class="d-flex a-center j-start ml-10" style="min-height:40px">
                    <span>{{ props.row.index + 1 }}</span>
                  </div>
                </q-td>
                <q-td key="servicedetail" :props="props">
                  <q-input dense :error="help.isDataEmpty(props.row.serviceDetail) && showError" hide-bottom-space v-model="props.row.serviceDetail" />
                </q-td>
                <q-td key="price" :props="props">
                  <q-input dense :error="help.isDataEmpty(props.row.price) && showError" hide-bottom-space v-model="props.row.price" />
                </q-td>
                <q-td key="time" :props="props">
                  <q-input dense placeholder="1 - 10" suffix="Hour" :error="help.isDataEmpty(props.row.time) && showError" hide-bottom-space v-model="props.row.time" />
                </q-td>
                <q-td key="action" :props="props">
                  <q-btn
                    @click="doDeleteWorkshopServices(props.row, props.row.index)"
                    label="Remove" flat rounded color="negative"
                    class="tf-capitalize col"
                  />
                </q-td>
              </q-tr>
            </template>
          </q-table>
        </q-card-section>
        <q-card-actions class="p-20 flex j-sp-between relative-position">
          <div class="q-gutter-x-sm">
            <q-btn
              class="tf-capitalize icon-resize"
              color="primary" icon="fas fa-plus"
              rounded label="New Periodic Service"
              @click="doAddNewCarPeriodicService()"
            />
            <q-btn
              class="tf-capitalize icon-resize"
              color="negative" rounded label="Remove All Periodic Services"
              @click="doDeleteAllWorkshopServicesByType(periodicServicesForms)"
            />
            <q-btn
              class="tf-capitalize icon-resize"
              color="primary" icon="fas fa-plus"
              rounded label="New General Service"
              @click="doAddNewCarGeneralService()"
            />
            <q-btn
              class="tf-capitalize icon-resize"
              color="negative" rounded label="Remove All General Services"
              @click="doDeleteAllWorkshopServicesByType(generalServicesForms)"
            />
          </div>
          <div class="q-gutter-x-sm">
            <q-btn class="tf-capitalize" color="primary" flat rounded label="Close" @click="dialogEditCarServices = false; periodicServicesForms = []"/>
            <q-btn class="tf-capitalize" color="primary" rounded label="Submit" @click="doUpdateWorkshopServices()" />
          </div>
        </q-card-actions>
      </q-card>
    </q-dialog>
  </q-page>
</template>

<script>
/* eslint-disable */
import { 
  getWorkshopDetailByUserID, 
  doUpdateWorkshopForAdminBengkel, 
  addNewWorkshopDetail, 
  deleteCarType, 
  deleteCarModel,
  addWorkshopService,
  deleteWorkshopServiceByID,
  deleteWorkshopServiceByStatusAndID
} from '../../../api/AdminWorkshopServices'
import help from '../../../js/help'
import ValidationFunction from '../../../js/ValidationFunction'
import Auth from '../../../js/AuthValidation'
import Swal from 'sweetalert2'

export default {
  data () {
    return {
      help,
      ValidationFunction,
      initialTab: 'editWorkshop',
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
      cmth: [
        { name: 'index', label: 'No', align: 'center', field: 'index', sortable: false },
        { name: 'carmodel', label: 'Car Model', align: 'center', field: 'carModel', sortable: false },
        { name: 'cartype', label: 'Car Type', align: 'center', field: 'carType', sortable: false }
      ],
      csh: [
        { name: 'index', label: 'No', align: 'left', field: 'index', sortable: false },
        { name: 'servicedetail', label: 'Service Name', align: 'left', field: 'serviceDetail', sortable: false },
        { name: 'price', label: 'Service Price', align: 'left', field: 'price', sortable: false },
        { name: 'time', label: 'Time Estimation', align: 'left', field: 'time', sortable: false },
        { name: 'action', label: 'Action', align: 'center', field: 'action', sortable: false }
      ],
      user: {},
      showError: false,
      accessToken: null,
      dialogEditCarServices: false,
      dialogEditCarTypeAndModel: false,
      editCarLoader: false,
      editCarServiceLoader: false,
      isEditableWorkshop: false,
      workshopDetail: {},
      workshop_details: [],
      carModelOptions: [],
      carTypeOptions: [],
      tempCarTypeOptions: [],
      periodicServicesOptions: [], // buat tampilan
      generalServicesOptions: [], // buat tampilan
      periodicServicesForms: [], // buat form edit
      generalServicesForms: [], // buat form edit
      carModelAndType: [],
      newCarModelAndType: [],
      jsonDataParam: {
        workshopID: null,
        userID: null,
        carModel: null,
        carType: null,
        workshopDetailID: null,
        serviceTypeBerkala: [],
        serviceTypeUmum: [],
        carTypeValue: null,
      },
      jsonDataParamTable: {
        iPage: 1,
        maxPage: 5
      },
      periodic: false,
      general: false
    }
  },
  created () {
    this.user = Auth.getUserDetails()
    this.accessToken = Auth.getAccessToken()
    this.doGetWorkshopDetailByUserID(false, false)
  },
  methods: {
    doGetWorkshopDetailByUserID (deleteCarSpec, deleteCarServ) {
      let _this = this
      this.loader = true
      getWorkshopDetailByUserID(_this.user.id).then(response => {
        _this.loader = true
        _this.workshopDetail = response.data.objectReturn
        // loopingan data servis
        _this.doClearDataV2()
        _this.workshopDetail.workshop_details.forEach(el1 => {
            let tempArr = []
            //for car model option
            let tempString1 = ""
            tempString1 = el1.carModel
            _this.carModelOptions.push(tempString1)

            //for car type option
            let tempObj = {
              id: el1.id,
              carModel: el1.carModel,
              carType: el1.carType
            }
            _this.tempCarTypeOptions.push(tempObj)
          _this.workshopDetail.workshop_services.forEach(el2 =>{
            if(el2.workshopDetailID === el1.id){
              tempArr.push(el2)
            }
          })

          let tempObject = {
            id: el1.id,
            workshopId: el1.workshopID,
            carModel: el1.carModel,
            carType: el1.carType,
            workshop_services: tempArr,
            created_at: el1.created_at,
            updated_at: el1.updated_at,
          }
          _this.workshop_details.push(tempObject)
        })
        _this.carModelOptions = ValidationFunction.arrayFilterWithSet(_this.carModelOptions)
        _this.loader = false
      }) .finally(() => {
        if(deleteCarSpec){
          _this.doFilterCarModelAndType(false)
        } else if (deleteCarServ){
          _this.doGetCarServices(_this.jsonDataParam.carTypeValue, true)
        }
      }) .catch((err) =>{
        console.log(err)
        _this.loader = false
      })
    },
    doFilterCarType (val) {
      this.doClearData()
      let tempArr = []
      const needle = val.toLocaleLowerCase()
      tempArr = this.tempCarTypeOptions.filter(v => v.carModel.toLocaleLowerCase().indexOf(needle) > -1)
      tempArr.forEach(el1 => {
        let tempString = ""
        tempString = el1.carType
        this.carTypeOptions.push(tempString)
      })
    },
    doGetCarServices(val, fromRemove){
      // get car model n type id
      this.generalServicesOptions = []
      this.periodicServicesOptions = []
      let selectedCarType = []
      this.jsonDataParam.carTypeValue = val
      const needle1 = val.toLocaleLowerCase()
      selectedCarType = this.workshopDetail.workshop_details.filter(v => v.carType.toLocaleLowerCase().indexOf(needle1) > -1)[0]
      this.jsonDataParam.workshopID = selectedCarType.workshopID
      this.jsonDataParam.workshopDetailID = selectedCarType.id
      // get services by model n type id and separate services by type
      let tempArrServices = []
      const needle2 = selectedCarType.id
      let tempArrPeriodic = []
      let tempArrGeneral = []

      tempArrServices = this.workshopDetail.workshop_services.filter(v => v.workshopDetailID == needle2)
      // Periodic
      tempArrPeriodic = tempArrServices.filter(v => v.serviceType.toLocaleLowerCase().indexOf('servis berkala') > -1)
      tempArrPeriodic.forEach(el1 => {
        console.log(el1)
        let tempObj = {
          serviceID: el1.id,
          serviceType: el1.serviceType,
          workshopID: el1.workshopID,
          workshopDetailID: el1.workshopDetailID,
          serviceDetail: el1.serviceDetail,
          price: el1.price,
          time: el1.time
        }
        this.periodicServicesOptions.push(tempObj)
      })
      console.log(this.periodicServicesOptions, this.generalServicesOptions)
      // General
      tempArrGeneral = tempArrServices.filter(v => v.serviceType.toLocaleLowerCase().indexOf('servis umum') > -1)
      tempArrGeneral.forEach(el1 => {
        let tempObj1 = {
          serviceID: el1.id,
          serviceType: el1.serviceType,
          workshopID: el1.workshopID,
          workshopDetailID: el1.workshopDetailID,
          serviceDetail: el1.serviceDetail,
          price: el1.price,
          time: el1.time
        }
        this.generalServicesOptions.push(tempObj1)
      })
      console.log(this.periodicServicesOptions, this.generalServicesOptions)
      if(fromRemove){
        this.doFilterCarServices(false)
      }
    },
    doFilterCarModelAndType (fromButton) {
      let _this = this
      if(fromButton){
        _this.dialogEditCarTypeAndModel = true
        _this.editCarLoader = true
      }
      _this.carModelAndType = []
      _this.carModelOptions.forEach((el1, index) => {
        let tempObj = {
          index: index,
          carModel: el1,
          carType: []
        }
        _this.tempCarTypeOptions.forEach(el2 => {
          let tempObj2 = {
            id: el2.id,
            name: el2.carType
          }
          if(el1 == el2.carModel){
            tempObj.carType.push(tempObj2)
          }
        })
        _this.carModelAndType.push(tempObj)
      })
    },
    doUpdateCarModelAndType () { // untuk update tampilan
      let _this = this
      var edited = false
      _this.workshopDetail.workshop_details.forEach(el1 => { // for update data
        _this.carModelAndType.forEach(el2 => {
          el2.carType.forEach(el3 => {
            if(el1.carModel == el2.carModel){
              if(el1.id == el3.id && el1.carType !== el3.name){
                el1.carType = el3.name
                edited = true
              }
            }
          })
        })
      })
      var tempArr = [] // for add new
      var tempArrBackendFormat = [] // for add new data format backend
      _this.carModelAndType.forEach(el1 => { // for add new sekaligus dari data yg udh ada
        if(!help.isDataEmpty(el1.id) && el1.id == '#1'){
          tempArr.push(el1)
        }
        el1.carType.forEach(el2 => {
          if(el2.id == '#2'){
            let tempObj = {
              id: el2.id,
              carModel: el1.carModel,
              carType: el2.name
            }
            tempArr.push(tempObj)
          }
        })
      })
      if(!help.isObjectEmpty(tempArr)){
        console.log(tempArr)
        tempArr.forEach(el1 => {
          if(!help.isDataEmpty(el1.id) && el1.id == '#1'){
            el1.carType.forEach(el2 => {
              let tempObj = {
                carModel: el1.carModel,
                carType: el2.name
              }
              tempArrBackendFormat.push(tempObj)
            })
          } else if (!help.isDataEmpty(el1.id) && el1.id == '#2') {
            let tempObj = {
              carModel: el1.carModel,
              carType: el1.carType
            }
            tempArrBackendFormat.push(tempObj)
          }
        })
      }
      if(edited){
        doUpdateWorkshopForAdminBengkel(_this.workshopDetail, this.accessToken).then(response => {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.data.messageAll
          }) .then(() => {
            _this.showError = false
            // _this.dialogEditCarTypeAndModel = false
            if(!help.isObjectEmpty(tempArrBackendFormat)){
              _this.doGetWorkshopDetailByUserID(true, false)
            } else {
              _this.doGetWorkshopDetailByUserID(true, false)
            }
          })
        }) .catch((error) => {
          if(error.response.status === 401) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: error.response.data.message
            }) .then(() => {
              _this.showError = true
            })
          }
        })
      }
      if(!help.isObjectEmpty(tempArrBackendFormat)){
        let tempObj = {
          workshopDetail: []
        }
        tempObj.workshopDetail = tempArrBackendFormat
        addNewWorkshopDetail(_this.workshopDetail.id, tempObj, this.accessToken).then(response => {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.data.messageAll
          }) .then(() => {
            _this.showError = false
            // _this.dialogEditCarTypeAndModel = false
            if(!edited){
              _this.doGetWorkshopDetailByUserID(true, false)
            }
          })
        }) .catch((error) => {
          if(error.response.status === 401) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: error.response.data.message
            }) .then(() => {
              _this.showError = true
            })
          }
        })
      }
    },
    doAddNewCarModelAndType () { // buat tampilan
      const tempObj = {
        index: this.carModelAndType.length,
        id: '#1',
        carModel: null,
        carType: [
          { name:null }
        ]
      }
      this.carModelAndType.push(tempObj)
    },
    doAddNewCarType (index, fromExisting) { // buat tampilan
      if(fromExisting){
        var tempObj = {
          id: '#2',
          name: null
        }
      } else {
        var tempObj = {
          name: null
        }
      }
      this.carModelAndType[index].carType.push(tempObj)
    },
    deleteCarModelAndType (index, item) {
      if(item.id == '#1'){
        this.carModelAndType.splice(index, 1)
        this.carModelAndType.forEach((el1, index) => { // buat sort ulang index q-table
          el1.index = index
        })
      } else {
        this.doDeleteCarModelAndTypeFromExisting(item)
      }
    },
    deleteCarTypeForm (index, index1) {
      if(this.carModelAndType[index].carType[index1].id == '#2'){
        this.carModelAndType[index].carType.splice(index1, 1)
      } else {
        this.doDeleteCarTypeFromExisting(index, index1)
      }
    },
    doDeleteCarModelAndTypeFromExisting (item) {
      let _this = this
      _this.editCarLoader = true
      deleteCarModel(_this.workshopDetail.id, item.carModel, _this.accessToken).then(response => {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.data.message
        }) .then(() => {
          _this.doGetWorkshopDetailByUserID(true, false)
          _this.editCarLoader = false
        })
      }) .catch((error) => {
        console.log(error)
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Please contact our admin'
        }) .then(() => {
          _this.editCarLoader = false
        })
      })
    },
    doDeleteCarTypeFromExisting (index, index1) {
      let _this = this
      _this.editCarLoader = true
      let item = _this.carModelAndType[index].carType[index1]
      console.log(item)
      deleteCarType(_this.workshopDetail.id, item.id, _this.accessToken).then(response => {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.data.message
        }) .then(() => {
          _this.doGetWorkshopDetailByUserID(true, false)
          _this.editCarLoader = false
        })
      }) .catch((error) => {
        console.log(error)
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Please contact our admin'
        }) .then(() => {
          _this.editCarLoader = false
        })
      })
    },
    doFilterCarServices (fromButton) {
      let _this = this
      if(fromButton){
        _this.dialogEditCarServices = true
      }
      _this.periodicServicesForms = []
      _this.generalServicesForms = []
      _this.periodicServicesOptions.forEach((el1, index) => { // Periodic services
        let tempObj = {
          index: index,
          serviceID: el1.serviceID,
          workshopID: el1.workshopID,
          workshopDetailID: el1.workshopDetailID,
          serviceDetail: el1.serviceDetail,
          serviceType: el1.serviceType,
          price: el1.price,
          time: el1.time,
          action: null
        }
        _this.periodicServicesForms.push(tempObj)
      })
      _this.generalServicesOptions.forEach((el1, index) => { // General services
        let tempObj = {
          index: index,
          serviceID: el1.serviceID,
          workshopID: el1.workshopID,
          workshopDetailID: el1.workshopDetailID,
          serviceDetail: el1.serviceDetail,
          serviceType: el1.serviceType,
          price: el1.price,
          time: el1.time,
          action: null
        }
        _this.generalServicesForms.push(tempObj)
      })
      console.log('halo mas', _this.periodicServicesForms)
    },
    doAddNewCarPeriodicService () { // Buat tampilan PERIODIC SERVICES
      let tempObj = {
        index: this.periodicServicesForms.length,
        serviceID: null,
        workshopID: this.jsonDataParam.workshopID,
        workshopDetailID: this.jsonDataParam.workshopDetailID,
        serviceType: 'servis berkala',
        id: '#1',
        serviceDetail: null,
        price: null,
        time: null,
        action: null
      }
      console.log(this.periodicServicesForms)
      this.periodicServicesForms.push(tempObj)
    },
    doAddNewCarGeneralService () { // Buat tampilan GENERAL SERVICES
      let tempObj = {
        index: this.generalServicesForms.length,
        serviceID: null,
        workshopID: this.jsonDataParam.workshopID,
        workshopDetailID: this.jsonDataParam.workshopDetailID,
        serviceType: 'servis umum',
        id: '#1',
        serviceDetail: null,
        price: null,
        time: null,
        action: null
      }
      console.log(this.generalServicesForms)
      this.generalServicesForms.push(tempObj)
    },
    doUpdateWorkshopServices () { // Update Workshop Services 
      let _this = this
      var edited = false
      let tempBackendFormat = {
        serviceTypeBerkala: [],
        serviceTypeUmum: []
      }
      _this.workshopDetail.workshop_services.forEach(el1 => { // for update data
        _this.periodicServicesForms.forEach(el2 => {
          if(el2.serviceID == el1.id){
            if(el2.serviceDetail !== el1.serviceDetail){
              el1.serviceDetail = el2.serviceDetail
              edited = true
            }
            if(el2.price !== el1.price){
              el1.price = el2.price
              edited = true
            }
            if(el2.time !== el1.time){
              el1.time = el2.time
              edited = true
            }
          }
        })
        _this.generalServicesForms.forEach(el2 => {
          if(el2.serviceID == el1.id){
            if(el2.serviceDetail !== el1.serviceDetail){
              el1.serviceDetail = el2.serviceDetail
              edited = true
            }
            if(el2.price !== el1.price){
              el1.price = el2.price
              edited = true
            }
            if(el2.time !== el1.time){
              el1.time = el2.time
              edited = true
            }
          }
        })
      })
      _this.periodicServicesForms.forEach(el1 => {
        if(!help.isDataEmpty(el1.id) && el1.id == '#1'){
          tempBackendFormat.serviceTypeBerkala.push(el1)
        }
      })
      _this.generalServicesForms.forEach(el1 => {
        if(!help.isDataEmpty(el1.id) && el1.id == '#1'){
          tempBackendFormat.serviceTypeUmum.push(el1)
        }
      })
      console.log(tempBackendFormat)
      // if(help.isObjectEmpty(tempBackendFormat.serviceTypeBerkala)){
      //   delete tempBackendFormat.serviceTypeBerkala
      // }
      // if(help.isObjectEmpty(tempBackendFormat.serviceTypeUmum)){
      //   delete tempBackendFormat.serviceTypeUmum
      // }
      if(edited){
        doUpdateWorkshopForAdminBengkel(_this.workshopDetail, this.accessToken).then(response => {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.data.messageAll
          }) .then(() => {
            _this.showError = false
            // _this.dialogEditCarTypeAndModel = false
            if(!help.isObjectEmpty(tempBackendFormat.serviceTypeBerkala) || !help.isObjectEmpty(tempBackendFormat.serviceTypeUmum)){
              _this.doGetWorkshopDetailByUserID(false, true)
            } else {
              _this.doGetWorkshopDetailByUserID(false, true)
            }
          })
        }) .catch((error) => {
          if(error.response.status === 401) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: error.response.data.message
            }) .then(() => {
              _this.showError = true
            })
          }
        })
      }
      if(!help.isObjectEmpty(tempBackendFormat.serviceTypeBerkala) || !help.isObjectEmpty(tempBackendFormat.serviceTypeUmum)){
        console.log('masuk')
        addWorkshopService(tempBackendFormat, _this.accessToken).then(response => {
          Swal.fire({
            icon: 'success',
            title: 'Success',
            text: response.data.messageAll
          }) .then(() => {
            _this.showError = false
            // _this.dialogEditCarTypeAndModel = false
            if(!edited){
              _this.doGetWorkshopDetailByUserID(false, true)
            }
          })
        }) .catch((error) => {
          if(error.response.status === 401) {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: error.response.data.message
            }) .then(() => {
              _this.showError = true
            })
          }
        })
      }
    },
    doDeleteWorkshopServices (item, index) {
      if(item.id == '#1' && item.serviceType == 'servis berkala'){
        this.periodicServicesForms.splice(index, 1)
        this.periodicServicesForms.forEach((el1, index) => { // buat sort ulang index q-table
          el1.index = index
        })
      } else if (item.id == '#1' && item.serviceType == 'servis umum') {
        this.generalServicesForms.splice(index, 1)
        this.generalServicesForms.forEach((el1, index) => { // buat sort ulang index q-table
          el1.index = index
        })
      } else if (help.isDataEmpty(item.id)){
        this.doDeleteWorkshopServiceByID(item)
      }
    },
    doDeleteWorkshopServiceByID (item) {
      let _this = this
      _this.editCarServiceLoader = true
      deleteWorkshopServiceByID(item.workshopDetailID, item.serviceID, _this.accessToken).then(response => {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.data.message
        }) .then(() => {
          _this.showError = false
          _this.editCarServiceLoader = false
          _this.doGetWorkshopDetailByUserID(false, true)
        })
      }) .catch((error) => {
        console.log(error)
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Please contact our admin'
        }) .then(() => {
          _this.showError = true
          _this.editCarServiceLoader = false
        })
      })
    },
    doDeleteAllWorkshopServicesByType (item) {
      let _this = this
      let firstItem = item[0]
      deleteWorkshopServiceByStatusAndID(firstItem.workshopDetailID, firstItem.serviceType, _this.accessToken).then(response => {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.data.message
        }) .then(() => {
          _this.showError = false
          _this.editCarServiceLoader = false
          _this.doGetWorkshopDetailByUserID(false, true)
        })
      }) .catch((error) => {
        console.log(error)
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: 'Please contact our admin'
        }) .then(() => {
          _this.showError = true
          _this.editCarServiceLoader = false
        })
      })
    },
    doClearDataV2 () {
      this.carModelOptions = []
      this.carModelAndType = []
      this.tempCarTypeOptions = []
      this.newCarModelAndType = []
    },
    doClearData () {
      this.carTypeOptions = []
      this.periodic = false
      this.general = false
      this.jsonDataParam.carType = null
      this.jsonDataParam.workshopDetailID = null
      this.jsonDataParam.workshopID = null
      this.jsonDataParam.carTypeValue = null
      this.generalServicesOptions = []
      this.periodicServicesOptions = []
      this.generalServicesForms = []
      this.periodicServicesForms = []
    },
    doConsole (a) {
      console.log(a)
    },
    doNothing(){}
  }
}
</script>
