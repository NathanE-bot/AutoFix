<template>
    <q-page class="flex a-end flex-center chat-room-page">
        <div class="fw p-20">
            <div class="w-80 m-auto">
                <div class="" v-for="item in messages" :key="item">
                    <div :class="[{'time-layout-not-sent' : item.username != user.fullName},{'time-layout-sent' : item.username == user.fullName}]">
                        <span v-if="item.username == user.fullName">{{ help.defaultFormat(item.time, help.data().time_4) }}</span>
                        <q-chat-message class="chat-message-bubble"
                            :text="[item.message]" :bg-color="item.username != user.fullName ? 'primary' : ''"
                            :sent="item.username == user.fullName ? true : false"
                        />
                        <span v-if="item.username != user.fullName">{{ help.defaultFormat(item.time, help.data().time_4) }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex a-center w-80 m-auto py-20">
                <q-input
                    @keydown.enter="sendMessage()"
                    v-model="messageInput"
                    placeholder="Write a reply..."
                    borderless dense autogrow
                    class="bg-white br-10px textarea-chat mr-20 fw"
                />
                <q-btn @click="sendMessage()" round color="secondary" icon="far fa-paper-plane"></q-btn>
            </div>
        </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import help from '../../js/help'
import main from '../../main'
import { LocalStorage } from 'quasar'

export default {
  data() {
    return {
        help,
        messageInput: '',
        userName: "",
        name: null,
        showMessage: "",
        messages: [],
        roomId: null,
        user: LocalStorage.getItem('autoRepairUser').data.user
    };
  },
  methods: {
    updateUsername() {
      this.name = this.userName
      this.userName = ""
    },
    sendMessage() {
      const message = {
        time: new Date().getTime(),
        username: this.user.fullName,
        message: this.messageInput
      }
      console.log(this.messageInput)
      console.log(this.messageInput == '\n')
      if(this.messageInput !== "" && !this.messageInput.includes("\\n")){
        main
            .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
            .ref("chatRoom/" + this.roomId)
            .push(message)
        this.messageInput = ""
      }
    }
  },
  mounted() {
    window.scrollTo(0,document.body.scrollHeight)
    let _this = this
    _this.roomId = _this.$route.params.id
    if(!help.isDataEmpty(_this.roomId)){
        const itemsRef = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("chatRoom/" + _this.roomId);
        itemsRef.on("value", snapshot => {
            let data = snapshot.val()
            let messages = []
            Object.keys(data).forEach(key => {
                if([key] != 'user-1' && [key] != 'user-2'){
                    messages.push({
                        id: key,
                        username: data[key].username,
                        message: data[key].message,
                        time: data[key].time
                    })
                }
            })
            _this.messages = messages
        })
    } 
  }
};
</script>
