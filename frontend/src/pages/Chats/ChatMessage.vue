<template>
    <q-page class="flex flex-center">
      <div class="login mt-5" v-if="!name">
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
              v-for="message in messages"
              :key="message"
            >
              <span class="mg-text">{{ message.username }}</span>
              <p class="message pt-1">{{ message.text }}</p>
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
      messages: []
    };
  },
  methods: {
    updateUsername() {
      this.name = this.userName;
      this.userName = "";
    },
    sendMessage() {
      const user = LocalStorage.getItem('autoRepairUser').data.user;
      const message = {
        time: new Date().getTime(),
        username: user.fullName,
        message: this.showMessage
      };
      main
        .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
        .ref("message/kennytatang")
        .push(message);
      this.showMessage = "";
    }
  },
  mounted() {
    console.log(LocalStorage.getItem('autoRepairUser').data.user)
    let viewMessage = this;
    const itemsRef = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("message/kennytatang");
    itemsRef.on("value", snapshot => {
      let data = snapshot.val();
      let messages = [];
      Object.keys(data).forEach(key => {
        messages.push({
          id: key,
          username: data[key].username,
          message: data[key].message,
          time: data[key].time
        });
      });
      console.log(messages)
      viewMessage.messages = messages;
    });
  }
};
</script>
