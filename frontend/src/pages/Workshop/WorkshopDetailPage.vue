<template>
  <div class="">
    <q-parallax :height="120" :speed="0.5">
      <template v-slot:media>
        <img src="~assets/images/background_img/car_bg_1.jpg">
      </template>
    </q-parallax>
    <div class="content-border px-80">
      <div  class="flex flex-center flex-start" style="position:relative; bottom:70px;">
          <img class="img-logo" src="~assets/images/background_img/car_bg_1.jpg" alt="">
      </div>
      <div class="flex flex-center flex-start content-logo">
        Tanggerang, Jakarta
      </div>
      <!-- bagian jam dan servis -->
      <!-- judul content jam dan servis -->
      <div class="content-jam-servis">
        <div class="flex">
          <!-- judul jam -->
          <div class="judul-jam">
             <div style="font-size:30px;">Jam Operational</div>
          </div>
          <!-- judul servis -->
          <div class="judul-servis" >
            <div style="font-size:30px;">Services</div>
          </div>
        </div>
      </div>
      <!-- isi content dari masing - masing jam dan servis -->
      <div class="content-jam-servis">
        <div class="flex">
          <!-- content jam -->
          <div class="content-jam">
            <ul style="list-style-type:none; font-size:20px; padding-left 20px;">
              <li>Senin   07:00 - 16:00</li>
              <li>Selasa  07:00 - 16:00</li>
              <li>Rabu    07:00 - 16:00</li>
            </ul>
          </div>
          <!-- vertical line -->
          <div class="vertical-line"></div>
          <!-- content servis -->
          <div class="content-servis" >
            <ul style="font-size:20px;">
              <li>change oil</li>
              <li>servis kaca</li>
              <li>servis ac</li>
            </ul>
          </div>
        </div>
      </div>
      <!--END bagian jam dan servis -->
      <!-- galery -->
      <div class="q-pa-md content-slider">
        <q-carousel
          swipeable
          animated
          v-model="slide"
          thumbnails
          infinite
        >
          <q-carousel-slide :name="1" img-src="~assets/images/background_img/car_bg_1.jpg" />
          <q-carousel-slide :name="2" img-src="~assets/images/background_img/car_bg_1.jpg" />
          <q-carousel-slide :name="3" img-src="~assets/images/background_img/car_bg_1.jpg" />
          <q-carousel-slide :name="4" img-src="~assets/images/background_img/car_bg_1.jpg" />
        </q-carousel>
      </div>
      <!-- END galery -->
      <!-- contact begin -->
      <!-- judul contact -->
      <div class="border-contact py-20">
        <div class="content-contact">
          contact
        </div>
      </div>
      <!-- end judul contact -->
      <!-- phone content -->
      <div class="flex py-30">
        <div class="icon-phone-border d-flex"><q-icon class="phone-icon" name="phone" /></div>
        <div class="content-nomor pl-30 flex flex-center">
          <div class="content-tulisan-nomor-1">Call Honda Indonesia</div>
          <div class="content-tulisan-nomor-2">0812899232</div>
        </div>
        <div class="flex flex-center"><button class="button-copy">Copy</button></div>
      </div>
      <div class="border-phone "></div>
      <!-- END phone content -->
      <!-- chat content -->
      <div class="flex py-30">
        <div class="icon-phone-border d-flex"><q-icon class="phone-icon" name="chat" /></div>
        <div class="content-nomor pl-30 flex flex-center">
          <div class="content-tulisan-nomor-1">Chat Honda Indonesia</div>
          <div class="content-tulisan-nomor-2">in apps chat message</div>
        </div>
      </div>
      <div class="border-phone "></div>
      <!-- END chat content -->
      <!-- email content -->
      <div class="flex py-30">
        <div class="icon-phone-border d-flex"><q-icon class="phone-icon" name="email" /></div>
        <div class="content-nomor pl-30 flex flex-center">
          <div class="content-tulisan-nomor-1">email Honda Indonesia</div>
          <div class="content-tulisan-nomor-2">Send Mail to honda</div>
        </div>
      </div>
      <div class="border-phone "></div>
      <!-- END email content -->
      <!-- location content -->
      <div class="flex py-30">
        <div class="icon-phone-border d-flex"><q-icon class="phone-icon" name="people" /></div>
        <div class="content-nomor pl-30 flex flex-center">
          <div class="content-tulisan-nomor-1">Find Honda Indonesia</div>
          <div class="content-tulisan-nomor-2">Jl. agustin raya nomor 5</div>
        </div>
        <div class="flex flex-center"><button class="button-copy">see on maps</button></div>
      </div>
      <div class="border-phone "></div>
      <!-- END location content -->
      <!-- END contact -->
      <div class="flex flex-center py-50"><button class="button-make-shedule">Make Your Schedule</button></div>
    </div>
  </div>
</template>
<script>
// import { ref } from 'vue'

export default {
  setup () {
    return {
      // slide: ref(1),
      // autoplay: ref(true)
    }
  }
}
</script>
