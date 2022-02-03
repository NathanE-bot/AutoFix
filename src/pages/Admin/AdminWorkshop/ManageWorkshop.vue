<template>
  <q-page class="w-80 m-auto p-20">
    <q-card class="br-10px">
      <q-tabs
        v-model="workshopTab"
        align="justify"
      >
        <q-tab class="tf-capitalize" name="workshop" label="Manage Workshop Profile" />
        <q-tab class="tf-capitalize" name="services" label="Manage Services" />
        <q-tab class="tf-capitalize" name="gallery" label="Manage Gallery" />
      </q-tabs>
      <q-separator />
      <q-tab-panels v-model="workshopTab" animated>
        <q-tab-panel name="workshop">
          <div>
            <div class="text-h6 fw-semibold mb-20">Workshop Details</div>
          </div>
          <div class="row j-sp-between a-center" style="min-height: 42px">
            <div class="text-subtitle2">Workshop Profile</div>
            <q-btn
               v-if="!isEditableWorkshop"
              @click="isEditableWorkshop = true"
              icon="fas fa-pen" flat round :loading="loader"
              class="edit-pen-btn edit-pen-btn-active"
            >
              <q-tooltip
                class="text-body2 txt-white bg-primary"
                anchor="center left" self="center end" :offset="[10, 0]">
                Edit Profile
              </q-tooltip>
            </q-btn>
            <div v-else class="d-flex a-center q-gutter-x-md">
              <q-btn
                v-if="isEditableWorkshop"
                @click="isEditableWorkshop = false; doGetWorkshopDetailByUserID(false, false)"
                :loading="loader" unelevated rounded color="negative" label="Cancel"
                class="tf-capitalize ml-20 fs-12"
              />
              <q-btn
                v-if="isEditableWorkshop"
                @click="doUpdateWorkshopDetails()"
                :loading="loader" unelevated rounded color="primary" label="Submit Update" class="tf-capitalize ml-20 fs-12"/>
            </div>
          </div>
          <div class="row">
            <div class="col-md-3">
              <div :class="['no-logo-layout-4 m-auto relative-position', {'m-auto' : help.isDataEmpty(jsonDataParam.editWorkshopObject.workshopLogo) && loader === false }]">
                <!-- <q-img
                  id="myImg"
                  :src="jsonDataParam.editWorkshopObject.workshopLogo"
                  :ratio="1" spinner-color="primary" class="br-5px"
                  spinner-size="40px"
                >
                  <div v-if="help.isDataEmpty(jsonDataParam.editWorkshopObject.workshopLogo)" class="absolute-full text-subtitle2 flex flex-center">
                    No Logo
                  </div>
                </q-img> -->
                <img :class="['responsive_img fit-content br-5px', {'z-opacity w-0-i' : help.isDataEmpty(jsonDataParam.editWorkshopObject.workshopLogo)}]" :src="jsonDataParam.editWorkshopObject.workshopLogo" id="myImg">
                <div v-if="help.isDataEmpty(jsonDataParam.editWorkshopObject.workshopLogo)">No Logo</div>
                <q-btn icon="fas fa-pen" fab-mini class="edit-logo-btn cursor-pointer" text-color="white" color="secondary" v-if="isEditableWorkshop">
                  <div class="input-hide">
                    <input class="cursor-pointer" type="file" accept=".png,.jpg,.jpeg" id="uploadDPUser" @change="doUploadLogoWorkshop($event)">
                  </div>
                </q-btn>
              </div>
            </div>
            <div class="col-md-3 px-10 q-col-gutter-y-sm">
              <div class="fs-12">
                <span class="">Workshop Name :</span>
                <q-input v-model="jsonDataParam.editWorkshopObject.workshopName" dense outlined :disable="!isEditableWorkshop"/>
              </div>
              <div class="fs-12">
                <span class="">Workshop Email :</span>
                <q-input v-model="jsonDataParam.editWorkshopObject.workshopEmail" dense outlined :disable="!isEditableWorkshop" />
              </div>
              <div class="fs-12">
                <span class="">Workshop Phone Number :</span>
                <q-input v-model="jsonDataParam.editWorkshopObject.workshopPhoneNumber" dense outlined :disable="!isEditableWorkshop"/>
              </div>
            </div>
            <div class="col-md-3 px-10 q-col-gutter-y-sm">
              <div class="fs-12">
                <span class="">District :</span>
                <q-input  v-model="jsonDataParam.editWorkshopObject.district" dense outlined :disable="!isEditableWorkshop"/>
              </div>
              <div class="fs-12">
                <span class="">City :</span>
                <q-input v-model="jsonDataParam.editWorkshopObject.city" dense outlined :disable="!isEditableWorkshop"/>
              </div>
              <div class="fs-12">
                <span class="">Province :</span>
                <q-input v-model="jsonDataParam.editWorkshopObject.province" dense outlined :disable="!isEditableWorkshop"/>
              </div>
            </div>
            <div class="col-md-3 px-10 q-col-gutter-y-sm">
              <div class="fs-12">
                <span class="">Latitude :</span>
                <q-input v-model="jsonDataParam.editWorkshopObject.latitude" dense outlined :disable="!isEditableWorkshop"/>
              </div>
              <div class="fs-12">
                <span class="">Longitude :</span>
                <q-input v-model="jsonDataParam.editWorkshopObject.longitude" dense outlined :disable="!isEditableWorkshop"/>
              </div>
            </div>
          </div>
          <br/>
          <div class="row">
            <div class="col-md-6 pr-10">
              <div class="fs-12">
                <span class="">Workshop Address :</span>
                <q-input autogrow maxlength="300" class="ta-r-none-200" v-model="jsonDataParam.editWorkshopObject.workshopAddress" outlined type="textarea" :disable="!isEditableWorkshop"/>
              </div>
            </div>
            <div class="col-md-6 pl-10">
              <div class="fs-12">
                <span class="">Workshop Description :</span>
                <q-input autogrow maxlength="300" class="ta-r-none-200" v-model="jsonDataParam.editWorkshopObject.workshopDescription" outlined type="textarea" :disable="!isEditableWorkshop"/>
              </div>
            </div>
          </div>
          <div class="row mb-20 mt-20">
            <div class="d-flex a-center col-6">
              <div class="text-h6 fw-semibold">Operational Workshop Hour</div>
              <q-toggle
                class="fw-semibold"
                v-model="jsonDataParam.status24Hr"
                :disable="!isEditableWorkshop"
                color="primary" label="24 Hour Status"
              >
                <q-tooltip
                  class="text-body2 txt-white bg-info"
                  anchor="bottom end" self="bottom left" :offset="[0, 20]">
                  <q-icon name="fas fa-info-circle" />
                  Toggle opening 24hr everyday
                </q-tooltip>
              </q-toggle>
            </div>
            <div class="col-6 d-flex a-center">
              <div class="text-h6 fw-semibold mr-20">Workshop Reviews</div>
              <q-badge style="padding:5px 10px" color="primary">
                <span>Rating</span>
                <div class="ml-8">
                  <i class="fas fa-star fs-10 mr-5"></i>
                  <span>{{ workshopDetail.rating }}</span>
                </div>
              </q-badge>
            </div>
            <q-table
              class="edit-car-spec-table col-6 px-12"
              virtual-scroll binary-state-sort hide-pagination
              :columns="ohwh"
              :rows="jsonDataParam.operationalWorkshopHours"
              row-key="id"
              :rows-per-page-options="[0]"
            >
              <template v-slot:body="props">
                <q-tr class="vertical-top">
                  <q-td key="operationaldate" :props="props">
                    <span :class="[{'fw-semibold' : jsonDataParam.status24Hr}]">
                      {{
                        props.row.operationalDate == '1' ? 'Monday' :
                        props.row.operationalDate == '2' ? 'Tuesday' :
                        props.row.operationalDate == '3' ? 'Wednesday' :
                        props.row.operationalDate == '4' ? 'Thrusday' :
                        props.row.operationalDate == '5' ? 'Friday' :
                        props.row.operationalDate == '6' ? 'Saturday' :
                        props.row.operationalDate == '0' ? 'Sunday' : '-'
                      }}
                    </span>
                  </q-td>
                  <q-td key="operationalopenhour" :props="props">
                    <q-input
                      v-model="props.row.operationalOpenHour"
                      :error="help.isDataEmpty(props.row.operationalOpenHour) && showError"
                      :disable="jsonDataParam.status24Hr || !isEditableWorkshop"
                      dense mask="##:##:##" hide-bottom-space
                    />
                  </q-td>
                  <q-td key="operationalclosehour" :props="props">
                    <q-input
                      v-model="props.row.operationalCloseHour"
                      :error="help.isDataEmpty(props.row.operationalOpenHour) && showError"
                      :disable="jsonDataParam.status24Hr || !isEditableWorkshop"
                      dense mask="##:##:##" hide-bottom-space
                    />
                  </q-td>
                </q-tr>
              </template>
            </q-table>
            <q-scroll-area
              v-if="!help.isObjectEmpty(workshopDetail.workshop_review)"
              :thumb-style="thumbStyle"
              :bar-style="barStyle"
              class="review-workshop-scrollbar col-6 px-12"
              style="min-height:inherit"
            >
              <q-card class="my-card review-card br-20px mb-20" v-for="(review, index) in workshopDetail.workshop_review" :key="'review' + index">
                <q-card-section class="relative-position">
                  <span class="review-date grey-5">{{ help.defaultFormat(review.reviewDate, help.data().dmy_6) }}</span>
                  <div class="review-content">
                    <div class="text-h6">{{ review.userName }}</div>
                    <div class="line-clamp-3 text-subtitle2 fs-12">{{ review.description }}</div>
                  </div>
                  <q-rating
                    class="review-rating"
                    v-model="review.rating"
                    readonly size="xs"
                    color="yellow-14"
                    icon="star_border"
                    icon-selected="star"
                  />
                </q-card-section>
              </q-card>
            </q-scroll-area>
            <div v-else class="col-6 px-12">
              <div class="text-subtitle2 fw-semibold">No Reviews Yet</div>
            </div>
          </div>
        </q-tab-panel>
        <q-tab-panel name="services">
          <div class="text-h6 fw-semibold">Car Specification and Services</div>
          <div class="row">
            <div class="row col-md-4 p-20">
              <div class="col-12 j-sp-between a-center mb-20">
                <div class="text-subtitle2">Car Model and Type</div>
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
              <q-select
                @update:model-value="doFilterCarType($event)"
                v-model="jsonDataParam.carModel"
                :options="carModelOptions"
                outlined
                class="br-10px default-select-2 w-80 mr-auto mb-20"
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
                class="br-10px default-select-2 w-80 mr-auto mb-20"
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
            <div class="col-md-8 p-20">
              <div class="col-12 j-sp-between a-center mb-20">
                <div class="text-subtitle2">Car Services</div>
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
        </q-tab-panel>
        <q-tab-panel name="gallery">
          <div class="row">
            <div class="col-12 mb-20">
              <div class="d-flex a-center">
                <div class="text-h6 fw-semibold mr-20">Gallery Workshop</div>
                <div class="text-subtitle2 fw-semibold">Max: 4 Images</div>
                <div class="d-flex a-center j-center">
                  <q-btn
                    v-if="jsonDataParam.galleryImagesForPreview.length < 4"
                    @click="addGalleryForm()"
                    icon="fas fa-plus"
                    flat round color="grey-5"
                  />
                </div>
                <!-- <q-btn
                  @click="doUploadToDatabaseGalleryWorkshop()"
                  label="Upload Photo Gallery"
                  unelevated rounded color="primary"
                  class="tf-capitalize icon-resize"
                /> -->
              </div>
            </div>
            <div :class="['row j-start w-94 m-auto']">
              <div class="px-12 mb-15" v-for="(image, index) in jsonDataParam.galleryImagesForPreview" :key="'galer-'+index">
                <div class="gallery-images">
                  <img class="responsive_img fit-content" width="500" height="250" :src="image.imageData" :id="'imageGallery-' + index" alt="">
                </div>
                <input style="color: transparent; width: 92px" class="cursor-pointer mt-10" type="file" accept=".png,.jpg,.jpeg" :id="'uploadGallery-' + index" @change="doUploadForGalleryWorkshop($event, image, index)">
              </div>
            </div>
          </div>
          <div class="row w-94 m-auto">
            <div class="text-h6 fw-semibold mb-20 col-12">Preview Gallery</div>
            <q-carousel
              v-if="help.isObjectEmpty(workshopDetail.workshop_picture)"
              v-model="gallerySlide"
              arrows swipeable thumbnails
              animated infinite :autoplay="10000"
              transition-prev="slide-right"
              transition-next="slide-left"
              transition-duration="2000"
              control-color="primary"
              class="bg-grey-1 rounded-borders col-12"
              :style="{height: window.heightAltered + 'px'}"
            >
              <q-carousel-slide v-for="n in 4" :key="'AIYE' + n" :name="n" img-src="~assets/images/background_img/car_bg_1.jpg" />
            </q-carousel>
            <q-carousel
              v-else
              v-model="gallerySlide"
              arrows swipeable thumbnails
              animated infinite :autoplay="10000"
              transition-prev="slide-right"
              transition-next="slide-left"
              transition-duration="2000"
              control-color="primary"
              class="bg-grey-1 rounded-borders col-12"
              :style="{height: window.heightAltered + 'px'}"
            >
              <q-carousel-slide v-for="(images, index) in jsonDataParam.galleryImagesForPreview" :key="'AIYE' + index" :name="index+1" :img-src="images.imageData" />
            </q-carousel>
          </div>
        </q-tab-panel>
      </q-tab-panels>
    </q-card>
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
                  <q-input
                    :error="help.isDataEmpty(props.row.serviceDetail) && showError" v-model="props.row.serviceDetail" />
                    dense hide-bottom-space
                  />
                </q-td>
                <q-td key="price" :props="props">
                  <q-input
                    v-model="props.row.price" :error="help.isDataEmpty(props.row.price) && showError"
                    class="input-bold" dense prefix="Rp." mask="###.###.###" reverse-fill-mask hide-bottom-space
                  />
                </q-td>
                <q-td key="time" :props="props">
                  <q-input
                    v-model="props.row.time" :error="help.isDataEmpty(props.row.time) && showError"
                    class="input-bold" dense placeholder="1 - 10" mask="##" suffix="Hour" hide-bottom-space
                  />
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
                  <q-input
                  :error="help.isDataEmpty(props.row.serviceDetail) && showError" v-model="props.row.serviceDetail" />
                  dense hide-bottom-space
                </q-td>
                <q-td key="price" :props="props">
                  <q-input
                    v-model="props.row.price" :error="help.isDataEmpty(props.row.price) && showError"
                    class="input-bold" dense prefix="Rp." mask="###.###.###" reverse-fill-mask hide-bottom-space
                  />
                </q-td>
                <q-td key="time" :props="props">
                  <q-input
                    v-model="props.row.time" :error="help.isDataEmpty(props.row.time) && showError"
                    class="input-bold" dense placeholder="1 - 10" mask="##" suffix="Hour" hide-bottom-space
                  />
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
                  <q-input
                   :error="help.isDataEmpty(props.row.serviceDetail) && showError" v-model="props.row.serviceDetail"
                   class="input-bold" dense hide-bottom-space />
                </q-td>
                <q-td key="price" :props="props">
                  <q-input
                    v-model="props.row.price" :error="help.isDataEmpty(props.row.price) && showError"
                    class="input-bold" dense prefix="Rp." mask="###.###.###" reverse-fill-mask hide-bottom-space
                  />
                </q-td>
                <q-td key="time" :props="props">
                  <q-input
                    v-model="props.row.time" :error="help.isDataEmpty(props.row.time) && showError"
                    class="input-bold" dense placeholder="1 - 10" mask="##" suffix="Hour" hide-bottom-space
                  />
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
                  <q-input
                    :error="help.isDataEmpty(props.row.serviceDetail) && showError"
                    dense hide-bottom-space v-model="props.row.serviceDetail" />
                </q-td>
                <q-td key="price" :props="props">
                  <q-input
                    v-model="props.row.price" :error="help.isDataEmpty(props.row.price) && showError"
                    class="input-bold" dense prefix="Rp." mask="###.###.###" reverse-fill-mask hide-bottom-space
                  />
                </q-td>
                <q-td key="time" :props="props">
                  <q-input
                    v-model="props.row.time" :error="help.isDataEmpty(props.row.time) && showError"
                    class="input-bold" dense placeholder="1 - 10" mask="##" suffix="Hour" hide-bottom-space
                  />
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
              rounded unelevated label="New Periodic Service"
              @click="doAddNewCarPeriodicService()"
            />
            <q-btn
              class="tf-capitalize icon-resize"
              color="negative" rounded unelevated label="Remove All Periodic Services"
              @click="doDeleteAllWorkshopServicesByType(periodicServicesForms)"
            />
            <q-btn
              class="tf-capitalize icon-resize"
              color="primary" icon="fas fa-plus"
              rounded unelevated label="New General Service"
              @click="doAddNewCarGeneralService()"
            />
            <q-btn
              class="tf-capitalize icon-resize"
              color="negative" rounded unelevated label="Remove All General Services"
              @click="doDeleteAllWorkshopServicesByType(generalServicesForms)"
            />
          </div>
          <div class="q-gutter-x-sm">
            <q-btn class="tf-capitalize" color="primary" flat rounded label="Close" @click="dialogEditCarServices = false; periodicServicesForms = []"/>
            <q-btn class="tf-capitalize" color="primary" rounded unelevated label="Submit" @click="doUpdateWorkshopServices()" />
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
  deleteWorkshopServiceByStatusAndID,
  updateLogoWorkshop,
  makeGaleryWorkshopPath
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
      window: {
        width: 0,
        height: 0,
        heightAltered: 0
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
      ohwh: [
        { name: 'operationaldate', label: 'Day', align: 'left', field: 'operationalDate', sortable: false },
        { name: 'operationalopenhour', label: 'Open Hour', align: 'left', field: 'operationalOpenHour', sortable: false },
        { name: 'operationalclosehour', label: 'Close Hour', align: 'left', field: 'operationalCloseHour', sortable: false }
      ],
      user: {},
      showError: false,
      loader: false,
      workshopTab: 'workshop',
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
        editWorkshopObject: {},
        operationalWorkshopHours: [],
        status24Hr: false,
        galleryImage: {},
        galleryImagesForPreview: [],
        workshopPictureID: null
      },
      jsonDataParamTable: {
        iPage: 1,
        maxPage: 5
      },
      periodic: false,
      general: false,
      gallerySlide: 1
    }
  },
  created () {
    this.user = Auth.getUserDetails()
    this.accessToken = Auth.getAccessToken()
    this.doGetWorkshopDetailByUserID(false, false)
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
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (40/100))
    },
    doGetWorkshopDetailByUserID (deleteCarSpec, deleteCarServ) {
      let _this = this
      _this.loader = true
      getWorkshopDetailByUserID(_this.user.id).then(response => {
        _this.workshopDetail = response.data.objectReturn
        // loopingan data servis
        _this.doClearDataV2()
        _this.jsonDataParam.editWorkshopObject = _this.workshopDetail
        _this.jsonDataParam.status24Hr = _this.workshopDetail.status24Hr == '1' ? true : false
        _this.workshopDetail.operationalWorkshop.forEach(el1 => {
          let tempObj = {
            id: el1.id,
            operationalCloseHour: el1.operationalCloseHour,
            operationalDate: el1.operationalDate,
            operationalOpenHour: el1.operationalOpenHour,
            workshopID: el1.workshopID,
            setOnToggle: false
          }
          if(_this.jsonDataParam.status24Hr){
            tempObj.setOnToggle = false
          }
          else if(!help.isDataEmpty(tempObj.operationalOpenHour) && !help.isDataEmpty(tempObj.operationalCloseHour)){
            tempObj.setOnToggle = true
          }
          _this.jsonDataParam.operationalWorkshopHours.push(tempObj)
        })
        console.log(_this.jsonDataParam.editWorkshopObject)
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
        _this.workshopDetail.workshop_review.reverse()
        if(help.isObjectEmpty(_this.workshopDetail.workshop_picture)){
          _this.addGalleryForm()
        } else {
          _this.jsonDataParam.galleryImagesForPreview = []
          _this.workshopDetail.workshop_picture.forEach(el1 => {
            let tempObject = {
              workshopPictureID: el1.id,
              uploaded: true,
              imageData: el1.workshopPicture
            }
            _this.jsonDataParam.galleryImagesForPreview.push(tempObject)
          })
        }
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
    // setForToggleStatus24Hr (val) { // for future use (undone)
    //   console.log(val)
    //   _this.jsonDataParam.operationalWorkshopHours.forEach(el1 => {
    //     if(val){
    //       el1.setOnToggle = false
    //     } else {
    //       el1.setOnToggle = true
    //     }
    //     if(!help.isDataEmpty(el1.operationalOpenHour) && !help.isDataEmpty(el1.operationalCloseHour)){
    //       el1.setOnToggle = true
    //     }
    //     console.log(el1.setOnToggle)
    //   })
    // },
    doUpdateWorkshopDetails () {
      let _this = this
      _this.loader = true
      if(typeof _this.jsonDataParam.editWorkshopObject.workshopLogo !== 'object'){
        _this.doUpdateDataWorkshopDetails()
      } else {
        updateLogoWorkshop(_this.workshopDetail.id, _this.jsonDataParam.editWorkshopObject.workshopLogo, _this.accessToken).then(response => {
          console.log(response.data)
          _this.doUpdateDataWorkshopDetails()
        }) .catch(function (error) {
          this.loader = false
          console.log(error.response)
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.response.data
          })
        })
      }
    },
    doUpdateDataWorkshopDetails () {
      let _this = this
      if(help.isDataEmpty(_this.jsonDataParam.editWorkshopObject.workshopLogo)){
        _this.jsonDataParam.editWorkshopObject.workshopLogo = null
      }
      _this.jsonDataParam.operationalWorkshopHours.forEach((el1, index) => { // Untuk OPERATIONAL HOUR
        if(el1.operationalOpenHour !== _this.workshopDetail.operationalWorkshop[index].operationalOpenHour){
          _this.workshopDetail.operationalWorkshop[index].operationalOpenHour = el1.operationalOpenHour
        }
        if(el1.operationalCloseHour !== _this.workshopDetail.operationalWorkshop[index].operationalCloseHour){
          _this.workshopDetail.operationalWorkshop[index].operationalCloseHour = el1.operationalCloseHour
        }
      })
      _this.workshopDetail.status24Hr = _this.jsonDataParam.status24Hr == true ? '1' : '0'
      doUpdateWorkshopForAdminBengkel(_this.workshopDetail, _this.accessToken).then(response => {
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: response.data.messageAll
        }) .then(() => {
          _this.isEditableWorkshop = false
        })
        _this.doGetWorkshopDetailByUserID(false, false)
      }) .catch((error) => {
        if(error.response.status === 401) {
          Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.response.data.message
          }) .then(() => {
            _this.loader = true
          })
        }
      })
    },
    doUploadLogoWorkshop (event) {
      var inputFile = event.target.files || event.dataTransfer.files
      if(!inputFile.length) return null

      var inputFileType = inputFile[0].type
      if(!help.isValidImageType(inputFileType)){
        Swal.fire ({
          icon: "error",
          title: "Input Error",
          text: "File type is not .png, .jpg, or .jpeg"
        })
        document.getElementById('uploadDPUser').value = ''
      } else {
        var reader = new FileReader() // Creating reader instance from FileReader() API

        var preview = document.getElementById('myImg') // Image reference
        var file = inputFile[0] // File refrence

        reader.addEventListener("load", function () { // Setting up base64 URL on image
          preview.src = reader.result
        }, false)
        reader.readAsDataURL(file)

        const formData = new FormData
        formData.set('image', file)
        this.jsonDataParam.editWorkshopObject.workshopLogo = formData
      }
    },
    doFilterEditWorkshop () {
      let _this = this
      _this.isEditableWorkshop = false
      _this.jsonDataParam.editWorkshopObject = {}
      // _this.workshopDetail = _this.jsonDataParam.editWorkshopObject
      _this.jsonDataParam.editWorkshopObject = _this.workshopDetail
      console.log(_this.jsonDataParam.editWorkshopObject, _this.workshopDetail)
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
    addGalleryForm () {
      let tempObj = {
        workshopPictureID: 0,
        uploaded: false,
        imageData: {}
      }
      this.jsonDataParam.galleryImagesForPreview.push(tempObj)
      console.log('asd', this.jsonDataParam.galleryImages)
    },
    doUploadForGalleryWorkshop (event, imageObj, index) {
      var inputFile = event.target.files || event.dataTransfer.files
      if(!inputFile.length) return null

      var inputFileType = inputFile[0].type
      if(!help.isValidImageType(inputFileType)){
        Swal.fire ({
          icon: "error",
          title: "Input Error",
          text: "File type is not .png, .jpg, or .jpeg"
        })
        document.getElementById('uploadGallery-' + index).value = ''
      } else {
        imageObj.uploaded = true
        var reader = new FileReader() // Creating reader instance from FileReader() API

        var preview = document.getElementById('imageGallery-' + index) // Image reference
        var file = inputFile[0] // File refrence

        reader.addEventListener("load", function () { // Setting up base64 URL on image
          preview.src = reader.result
        }, false)
        reader.readAsDataURL(file)
        const formData = new FormData
        formData.set('image', file)
        imageObj.imageData = file
        this.jsonDataParam.galleryImage = {}
        this.jsonDataParam.galleryImage = formData
        this.jsonDataParam.workshopPictureID = null
        this.jsonDataParam.workshopPictureID = imageObj.workshopPictureID
        this.doMakeImagePathForDatabase() // jdnya lgsng upload
      }
    },
    doMakeImagePathForDatabase () {
      let _this = this
      _this.loader = true
      makeGaleryWorkshopPath(_this.workshopDetail.id, _this.jsonDataParam.workshopPictureID, _this.jsonDataParam.galleryImage, _this.accessToken).then(response => {
        _this.doGetWorkshopDetailByUserID(false, false)
        Swal.fire({
          icon: 'success',
          title: 'Success',
          text: 'Upload success'
        })
      }) .catch((error) => {
        console.log(error)
        Swal.fire({
          icon: 'error',
          title: 'Error',
          text: error.response.data.message.image[0]
        }) .then(() => {
          _this.loader = false
        })
      })
    },
    doClearDataV2 () {
      this.carModelOptions = []
      this.carModelAndType = []
      this.tempCarTypeOptions = []
      this.newCarModelAndType = []
      this.jsonDataParam.editWorkshopObject = {}
      this.jsonDataParam.operationalWorkshopHours = []
      this.jsonDataParam.status24  = false
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
