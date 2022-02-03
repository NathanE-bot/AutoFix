<template>
    <q-page class="flex a-start flex-center chat-room-page p-20">
        <q-card class="my-card w-60 chat-card" :style="{minHeight: window.heightAltered + 'px', maxHeight: window.heightAltered + 'px'}">
            <q-card-section class="d-flex a-center receiver-name">
                <q-btn
                    @click="goBack()"
                    unelevated round outline
                    size="sm"
                    color="white"
                >
                    <i class="fas fa-chevron-left fs-16"></i>
                </q-btn>
                <div class="text-h6 fw-semibold txt-white ml-15">
                    {{ user.role == '2' ? user_1 : user_2 }}
                </div>
            </q-card-section>
            <q-card-section class="chat-section" :style="{minHeight: window.minHeightChatSection + 'px'}">
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
            </q-card-section>
            <q-card-section class="d-flex a-center input-message">
                <q-input
                    @keyup.enter="sendMessage($event)"
                    v-model="messageInput"
                    placeholder="Write a reply..."
                    borderless dense autogrow maxlength="1000"
                    class="bg-white br-10px textarea-chat mr-20 fw"
                />
                <q-btn @click="sendMessage()" round flat>
                    <is-send-message />
                </q-btn>
            </q-card-section>
        </q-card>
    </q-page>
</template>

<script>
/* eslint-disable */
import help from '../../js/help'
import main from '../../main'
import { LocalStorage } from 'quasar'
import isvgSendMessage from '../../components/IconSVG/isvg_send_message.vue'

export default {
  components: {
    isSendMessage: isvgSendMessage
  },
  data() {
    return {
        help,
        messageInput: '',
        userName: "",
        messages: [],
        user_1: null,
        user_2: null,
        roomId: null,
        user: LocalStorage.getItem('autoRepairUser').data.user,
        window: {
            width: 0,
            height: 0,
            heightAltered: 0,
            minHeightChatSection: 0
        }
    };
  },
  methods: {
    sendMessage(event) {
      const message = {
        time: new Date().getTime(),
        username: this.user.fullName,
        message: this.messageInput
      }
      if(help.isObjectEmpty(event)){
          if(this.messageInput != "" && !/\\n\\r/.test(this.messageInput) && !/^ *$/.test(this.messageInput)){
                main
                    .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
                    .ref("chatRoom/" + this.roomId)
                    .push(message)
                this.messageInput = ""
            }
      }
      else if(event.key == "Enter" && !event.shiftKey){
          if(this.messageInput != "" && !/\\n\\r/.test(this.messageInput) && !/^ *$/.test(this.messageInput)){
                main
                    .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
                    .ref("chatRoom/" + this.roomId)
                    .push(message)
                this.messageInput = ""
            }
        }
    },
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (16/100))
      this.window.minHeightChatSection = window.innerHeight - (window.innerHeight * (34/100))
    },
    scrollToBottom () {
        let tes = document.getElementsByClassName("chat-card")[0]
        let tes2 = tes.scrollHeight - tes.clientHeight
        console.log(tes.scrollTop, tes2)
        tes.scrollTop = tes2
    },
    doConsole (a) {
        console.log(a)
    },
    changePage (url) {
        this.$router.push(url)
    },
    goBack () {
        this.$router.go(-1)
    }
  },
  mounted() {
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
    let _this = this
    _this.roomId = _this.$route.params.id
    if(!help.isDataEmpty(_this.roomId)){
        const itemsRef = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("chatRoom/" + _this.roomId);
        itemsRef.on("value", snapshot => {
            let data = snapshot.val()
            let messages = []
            let user_1 = null
            let user_2 = null
            console.log(data)
            Object.keys(data).forEach(key => {
                if([key] != 'user-1' && [key] != 'user-2'){
                    messages.push({
                        id: key,
                        username: data[key].username,
                        message: data[key].message,
                        time: data[key].time
                    })
                } else {
                    if([key] == 'user-1'){
                        user_1 = data[key]
                    } else {
                        user_2 = data[key]
                    }
                }
            })
            _this.user_1 = user_1
            _this.user_2 = user_2
            _this.messages = messages
            setTimeout(() => {
                _this.scrollToBottom()
            }, 0);
        })
    } 
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  }
};
</script>
