<template>
    <q-page class="chat-page">
      <div class="room-section" v-if="true">
        <div class="content-section relative-position">
          <span class="time-pos">14.20 pm</span>
          <q-separator class="indicator mr-24" color="primary" vertical size="8px" />
          <q-avatar size="90px" style="background-color: #d9d9d9">
            <i class="fas fa-user grey-5 fs-50"></i>
          </q-avatar>
          <div class="d-flex flex-dir-col a-start ml-10">
            <div class="fs-18 fw-bold black_3">Tatang Madadang</div>
            <div class="text-subtitle2 ml-4 mb-0 grey_1 fw-lightbold line-clamp-3" style="white-space: pre-line">
              qwdqwdqwd qwd qwd qwd qwdqwdqwd qwd qwdqwd qwdqwd q
            </div>
          </div>
        </div>
      </div>
      <div class="flex flex-dir-col flex-center" v-else>
        <img class="responsive_img" style="width: 55%" src="~assets/images/preset/no_chat_image.png" alt="">
        <span class="fs-30 txt-white fw-semibold mt-10">Please begin your chat to see your chat list</span>
      </div>
      <div class="login mt-5" v-if="name">
        <h3 class="mt-5">Join Chat</h3>
        <label for="username">userName</label>
        <br />
        <input class="mb-3" type="text" v-model="userName" />
        <br />
        <button class="btn btn-primary" @click="updateUsername">Join Chat</button>
      </div>
      <!-- Chat section -->
      <div class="message-body mt-3" v-else>
        <h3>Chat</h3>
        <h5>Welcome {{ name }}!</h5>
        <div class="card">
          <div class="card-body">
            <div
              class="border pl-2 pt-1 ml-2 message-text mb-2"
              v-for="item in messagesView"
              :key="item"
            >
              <span class="mg-text">{{ item.username }}</span>
              <p class="message pt-1">{{ item.message }}</p>
            </div>
          </div>
        </div>
        <input v-model="showMessage" type="text" class="mt-3 mr-2 pl-2 pr-2" />
        <button class="btn btn-primary" @click="sendMessage">Send</button>
      </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import main from '../../main'
import { LocalStorage } from 'quasar'
export default {
  name: "App",
  data() {
    return {
      userName: "",
      name: null,
      showMessage: "",
      messagesView: []
    };
  },
  methods: {
    updateUsername() {
      this.name = this.userName
      this.userName = ""
    },
    sendMessage() {
      const user = LocalStorage.getItem('autoRepairUser').data.user
      const message = {
        time: new Date().getTime(),
        username: user.fullName,
        message: this.showMessage
      }
      main
        .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
        .ref("chatRoom/1s12e12r2-2d232d2222")
        .push(message)
      this.showMessage = ""
    }
  },
  mounted() {
    let _this = this
    const itemsRef = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("chatRoom/1s12e12r2-2d232d2222")
    const test = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("message")
    test.on("value", test1 => {
      // console.log('a', test1.val())
      Object.keys(test1.val()).forEach(key => {
        // console.log(key)
      })
    })
    itemsRef.on("value", snapshot => {
      let data = snapshot.val()
      let messages = []
      Object.keys(data).forEach(key => {
        if(key == 'user-1' || key == 'user-2'){
          console.log('TOLOL')
        } else {
          messages.push({
            id: key,
            username: data[key].username,
            message: data[key].message,
            time: data[key].time
          })
        }
      })
      _this.messagesView = messages
      console.log(_this.messagesView)
    })
  }
};
</script>
