<template>
    <q-header class="autorepair-header">
      <q-toolbar>
        <q-btn
          v-if="propIsDisabled"
          @click="toggleLeftDrawer"
          flat dense round
          icon="menu"
          aria-label="Menu"
        />
        <div class="relative-box">
          <img class="logo-img" src="../assets/images/logo.png" alt="">
        </div>
        <q-tabs
          v-model="initialTab"
          dense
          class="m-auto"
          active-color="primary"
          indicator-color="primary"
          align="justify"
        >
          <q-tab name="home" label="Home" />
          <q-tab name="workshop" label="Workshop" />
          <q-tab name="insurance" label="Insurance" />
          <q-tab name="aboutus" label="About Us" />
        </q-tabs>
        <div class="relative-position">
          <div class="float-button">
            <q-btn
              outline
              rounded
              color="primary"
              class="tf-capitalize mr-10 fw lg-rg-btn"
            >
              Login
            </q-btn>
            <q-btn
              unelevated
              rounded
              color="primary"
              class="tf-capitalize fw lg-rg-btn"
            >
              Register
            </q-btn>
          </div>
        </div>
      </q-toolbar>
    </q-header>
</template>

<script>
/* eslint-disable */
export default {
    props: {
        propLeftDrawerBtn: false,
        propIsDisabled: false
    },
    data () {
        return {
            leftDrawerOpen: false,
            initialTab: 'home'
        }
    },
    methods: {
        toggleLeftDrawer () {
            this.propLeftDrawerBtn = !this.propLeftDrawerBtn
        }
    }
}
</script>
