<template>
  <q-page>
    <div class="screen-for-print white-1bg p-20">
      <div class="row">
        <div class="row col-6 q-gutter-y-md">
          <div class="col-4">Insured Name</div><div class="col-1">:</div><div class="col-7">NAMANYA COYYY</div>
          <div class="col-4">Phone Number: </div><div class="col-1">:</div><div class="col-7">No Polis</div>
          <div class="col-4">Email Address: </div><div class="col-1">:</div><div class="col-7">Emailnya ANJAY</div>
        </div>
        <div class="row col-6 q-gutter-y-md">
          <div class="col-4">Cart Type and Brand</div><div class="col-1">:</div><div class="col-7">Mobil Tut Tut</div>
          <div class="col-4">Chassis Number</div><div class="col-1">:</div><div class="col-7">3asd685asd63zx</div>
          <div class="col-4">Polis Number</div><div class="col-1">:</div><div class="col-7">No Polis</div>
          <div class="col-4">Plate Number</div><div class="col-1">:</div><div class="col-7">Mobil Tut Tut</div>
        </div>
        <div class="col-4 mt-20">Address :</div>
        <div class="row col-12">
          <div class="">Alamat rumahnya tjoy asd asd asd asd asd asd asd asd asd asd asd as</div>
        </div>
      </div>
      <br/>
      <q-separator class="col-12" height="5px"/>
      <br/>
      <div class="row col-12">
        <div class="row col-6 q-gutter-y-md">
          <div class="col-4">Driver Name: </div><div class="col-1">:</div><div class="col-7">Kenny nabrak coy</div>
          <div class="col-4">Driver Driver License: </div><div class="col-1">:</div><div class="col-7">123456789</div>
          <div class="col-4">Driver Speed: </div><div class="col-1">:</div><div class="col-7">20 Km/jam</div>
          <div class="col-4">Driver Relation: </div><div class="col-1">:</div><div class="col-7">Anak Cucu Cicit Cecet</div>
        </div>
        <div class="row col-6 q-gutter-y-md">
          <div class="col-4">Incident Date</div><div class="col-1">:</div><div class="col-7">27 Mei 2000</div>
          <div class="col-4">Incident Time: </div><div class="col-1">:</div><div class="col-7">00:00</div>
          <div class="col-4">Incident Location</div><div class="col-1">:</div><div class="col-7">Jalan Tol KM 69</div>
          <div class="col-4">Vehicle Desc</div><div class="col-1">:</div><div class="col-7">text area desc gt, gw gangerti isinya apa</div>
        </div>
      </div>
      <br/>
      <q-separator class="col-12" height="5px"/>
      <br/>
      <div class="row col-12">
        <div class="row col-6 q-gutter-y-md">
          <div class="col-4">Taxi Online Status</div><div class="col-1">:</div><div class="col-7">Yes/No</div>
          <div class="col-4">Incident Status</div><div class="col-1">:</div><div class="col-7">Yes/No</div>
          <div class="col-4">Incident Status Desc</div><div class="col-1">:</div><div class="col-7">Nama Penabrak n No mobil penabrak</div>
        </div>
      </div>
    </div>
  </q-page>
</template>

<script>
/* eslint-disable */
export default {
    data () {
      return {
        user: {}
      }
    },
    methods: {
      changePage (url) {
        this.$router.push(url)
      }
    }
}
</script>