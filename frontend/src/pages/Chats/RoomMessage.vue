<template>
    <q-page class="flex a-start flex-center chat-room-page p-20">
        <q-card class="my-card w-60 chat-card" :style="{minHeight: window.heightAltered + 'px', maxHeight: window.heightAltered + 'px'}">
            <q-card-section class="d-flex a-center receiver-name">
                <q-btn
                    @click="changePage('/member/home-message')"
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
                    @keydown.enter="sendMessage($event)"
                    v-model="messageInput"
                    placeholder="Write a reply..."
                    borderless dense autogrow maxlength="1000"
                    class="bg-white br-10px textarea-chat mr-20 fw"
                />
                <q-btn @click="sendMessage()" round flat>
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2.01623 21.8377C2.00154 21.7988 1.99682 21.7569 2.00239 21.7158L4.0994 14.4667C4.11248 14.4215 4.13805 14.381 4.17316 14.3497C4.20824 14.3184 4.25143 14.2976 4.29777 14.2898C4.29781 14.2898 4.29786 14.2897 4.2979 14.2897L12.8322 12.8604L12.8394 12.8591L12.8466 12.8577C13.7859 12.672 13.7859 11.3275 12.8466 11.1417L12.8394 11.1403L12.8322 11.1391L4.2979 9.70971C4.29786 9.7097 4.29781 9.70969 4.29777 9.70968C4.25143 9.70183 4.20824 9.68107 4.17316 9.64979C4.13805 9.61848 4.11248 9.5779 4.0994 9.53271L2.00239 2.2836C1.99682 2.24253 2.00154 2.20063 2.01623 2.16171C2.03276 2.11793 2.06124 2.07967 2.09844 2.05128C2.13563 2.02289 2.18005 2.0055 2.22663 2.00111C2.27322 1.99671 2.3201 2.00548 2.36195 2.02641L2.58561 1.57922L2.36201 2.02643L21.8616 11.7762C21.8617 11.7763 21.8618 11.7764 21.862 11.7764C21.9033 11.7972 21.938 11.829 21.9623 11.8684C21.9867 11.9079 21.9996 11.9533 21.9996 11.9997C21.9996 12.0461 21.9867 12.0916 21.9623 12.1311C21.938 12.1704 21.9033 12.2022 21.862 12.223C21.8619 12.2231 21.8617 12.2231 21.8616 12.2232L2.36201 21.973L2.36195 21.973C2.3201 21.994 2.27322 22.0027 2.22663 21.9983C2.18005 21.9939 2.13563 21.9766 2.09844 21.9482C2.06124 21.9198 2.03276 21.8815 2.01623 21.8377Z" fill="#21A17B" stroke="white"/>
                    </svg>
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

export default {
  data() {
    return {
        help,
        messageInput: '',
        userName: "",
        name: null,
        showMessage: "",
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
    updateUsername() {
      this.name = this.userName
      this.userName = ""
    },
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
