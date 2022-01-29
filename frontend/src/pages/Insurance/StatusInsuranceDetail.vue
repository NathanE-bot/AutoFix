<template>
  <q-page class="flex flex-center insurance_layout_3">
    <div class="flex flex-dir-col w-80 m-auto">
      <q-card class="br-20px">
        <q-card-section>
          <div class="row j-sp-between p-20">
            <span class="fw-semibold fs-28 tf-capitalize">{{ data.insuranceName }}</span>
            <q-badge
              class="tf-capitalize mr-10 p-10 fs-18  br-20px"
              :color="
                data.insuranceStatus === 'Approved'
                  ? 'primary' : data.insuranceStatus === 'Rejected'
                  ? 'negative': 'grey'"
              text-color="#ffffff"
              :label="data.insuranceStatus"
            />
          </div>
          <div class="col-12 fs-18 px-20">
            <div class="row py-10">Nama Pengemudi : {{ data.insuredName }}</div>
            <div class="row py-10">Tanggal : {{ data.claimedInsuranceDate }}</div>
            <div class="row py-10">Nomor Polis : {{ data.polisNumber }}</div>
          </div>
          <br/>
          <div class="row">
            <div class="col-8 m-auto border-card br-20px flex flex-center fs-20" style="height: 10rem;">
              <span>{{ data.insuranceDescription }}</span>
            </div>
          </div>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script>
/* eslint-disable */
import { LocalStorage } from "quasar";
import { getInsuranceDetailByStatusAccepted, getInsuranceDetailByStatusRejected } from "../../api/InsuranceService";
export default {
  data() {
    return {
      user: {},
      dataHitAPI: {},
      loader: false,
      data: {},
    };
  },
  created() {
    this.user = LocalStorage.getItem("autoRepairUser").data;
    this.dataHitAPI = {
      insuranceID: Number(this.$route.params.insuranceID),
      userID: this.user.user.id,
    };
    this.doGetInsuranceDetailByStatus();
  },
  methods: {
    doGetInsuranceDetailByStatus() {
      this.loader = true;
      if(this.$route.params.insuranceStatus === 'Approved'){
        getInsuranceDetailByStatusAccepted(this.dataHitAPI.userID, this.dataHitAPI.insuranceID, this.user.access_token)
        .then((response) => {
            this.data = response.data[0];
            console.log(this.data)
          }
        );
      }else if (this.$route.params.insuranceStatus === 'Rejected'){
          getInsuranceDetailByStatusRejected(this.dataHitAPI.userID, this.dataHitAPI.insuranceID, this.user.access_token)
          .then((response) => {
            this.data = response.data[0];
          }
        );
      }
    },
  },
};
</script>
