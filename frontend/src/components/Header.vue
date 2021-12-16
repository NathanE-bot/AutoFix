<template>
    <q-header class="autorepair-header">
      <q-toolbar>
        <!-- <q-btn
          v-if="propIsDisabled"
          @click="toggleLeftDrawer"
          flat dense round
          icon="menu"
          aria-label="Menu"
        /> -->
        <div class="relative-box">
          <img class="logo-img fixed-top-left" src="../assets/images/logo.png" alt="">
        </div>
        <q-tabs
          v-model="initialTab"
          dense
          class="m-auto"
          active-color="primary"
          indicator-color="primary"
          align="justify"
        >
          <q-tab @click="changePage('/')" name="home" label="Home" />
          <q-tab name="workshop" label="Workshop" />
          <q-tab name="insurance" label="Insurance" />
          <q-tab name="aboutus" label="About Us" />
        </q-tabs>
        <div class="relative-position">
          <div class="float-button">
            <q-btn
              @click="changePage('/session/login')"
              outline
              rounded
              color="primary"
              class="tf-capitalize mr-10 fw lg-rg-btn"
            >
              Login
            </q-btn>
            <q-btn
              @click="changePage('/session/register')"
              unelevated
              rounded
              color="primary"
              class="tf-capitalize fw lg-rg-btn"
            >
              Register
            </q-btn>
          </div>
          <!-- <q-btn
            round unelevated
            color="primary"
            size="lg"
            @click="changePage('/youraccount')"
          >
            <q-avatar size="60px">
              <img src="https://cdn.quasar.dev/img/avatar2.jpg">
            </q-avatar>
          </q-btn> -->
        </div>
      </q-toolbar>
    </q-header>
</template>

<script>
/* eslint-disable */
export default {
    data () {
      return {
        initialTab: 'home'
      }
    },
    computed () {
      console.log(this.$router)
    },
    methods: {
      changePage (url) {
        this.$router.push(url)
      }
    }
}
</script>
