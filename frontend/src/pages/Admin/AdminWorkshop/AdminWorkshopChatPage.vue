<template>
  <q-page class="chat-page">
    <div class="w-80 m-auto">
      <div class="row white-bg br-10px" v-if="!loader">
        <div class="room-section-gap col-md-6" v-if="!help.isObjectEmpty(room)">
          <q-scroll-area
            :thumb-style="thumbStyle"
            :bar-style="barStyle"
            class="list-workshop-scrollbar left-chat-fix"
            :style="{height: window.heightRoom + 'px'}"
          >
            <div class="room-section cursor-pointer col-md-12" v-for="item in room" :key="item.roomSecureId" @click="changePageForChat(item)">
              <div class="content-section relative-position">
                <span class="time-pos tf-capitalize" v-if="!help.isDataEmpty(item.lastMessage.time)">{{ help.defaultFormat(item.lastMessage.time, help.data().time_4) }}</span>
                <q-separator class="indicator mr-24" color="primary" vertical size="8px" />
                <!-- <q-avatar size="90px" style="background-color: #d9d9d9">
                  <i class="fas fa-user grey-5 fs-50"></i>
                </q-avatar> -->
                <div class="d-flex flex-dir-col a-start ml-10">
                  <div class="fs-18 fw-bold black_3">{{ user.role == '2' ? item.user_1 : item.user_2 }}</div>
                  <div class="text-subtitle2 ml-4 mb-0 grey_1 fw-lightbold line-clamp-3" style="white-space: pre-line">
                    {{ item.lastMessage.message }}
                  </div>
                </div>
              </div>
            </div>
          </q-scroll-area>
        </div>
        <div class="room-section-gap col-md-6 d-flex a-center j-center" v-else>
          No Data
        </div>
        <div class="chat-room-page col-md-6">
          <q-card class="my-card chat-card">
            <q-card-section class="d-flex a-center receiver-name">
              <div class="text-h6 fw-semibold txt-white ml-15" v-if="clicked">
                {{ user.role == '2' ? user_1 : user_2 }}
              </div>
            </q-card-section>
            <q-card-section class="chat-section" id="chatSection">
              <q-scroll-area
                :thumb-style="thumbStyle"
                :bar-style="barStyle"
                class="list-workshop-scrollbar left-chat-fix"
                :style="{height: window.heightAltered + 'px'}"
              >
                <div v-if="clicked">
                  <div v-for="item in messages" :key="item">
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
                <div class="flex flex-center" :style="{height: window.heightAltered1 + 'px'}" v-else>
                  Choose message room to start messaging
                </div>
              </q-scroll-area>
            </q-card-section>
            <q-card-section class="d-flex a-center input-message" style="min-height: 74px">
              <q-input
                @keyup.enter="sendMessage($event)"
                v-model="messageInput" v-if="clicked"
                placeholder="Write a reply..."
                borderless dense autogrow maxlength="1000"
                class="bg-white br-10px textarea-chat mr-20 fw"
              />
              <q-btn @click="sendMessage()" round flat v-if="clicked">
                <is-send-message />
              </q-btn>
            </q-card-section>
          </q-card>
        </div>
      </div>
      <div v-else-if="loader">
        <div class="q-gutter-y-lg">
          <q-skeleton class="black-bg-loader br-20px" height="120px" width="100%" />
          <q-skeleton class="black-bg-loader br-20px" height="120px" width="100%" />
          <q-skeleton class="black-bg-loader br-20px" type="QToolbar" width="80%" />
          <q-skeleton class="black-bg-loader br-20px" type="rect" width="30%" />
          <q-skeleton class="black-bg-loader br-20px" type="text" width="20%" />
        </div>
      </div>
      <div class="flex flex-dir-col flex-center" v-else>
        <img class="responsive_img" style="width: 55%" src="~assets/images/preset/no_chat_image.png" alt="">
        <span class="fs-30 txt-white fw-semibold mt-10">Please begin your chat to see your chat list</span>
      </div>
    </div>
  </q-page>
</template>

<script>
/* eslint-disable */
import help from '../../../js/help'
import Auth from '../../../js/AuthValidation'
import main from '../../../main'
import isvgSendMessage from '../../../components/IconSVG/isvg_send_message.vue'

export default {
  components: {
    isSendMessage: isvgSendMessage
  },
  data () {
    return {
      help,
      loader: false,
      firstLoad: true,
      clicked: false,
      messageInput: '',
      tempMessageInput: '',
      user: {},
      userName: "",
      room: [],
      messages: [],
      user_1: null,
      user_2: null,
      roomId: null,
      thumbStyle: {
        right: '2px',
        borderRadius: '10px',
        backgroundColor: '#21a17b',
        width: '10px',
        opacity: 0.75
      },
      barStyle: {
        right: '2px',
        borderRadius: '10px',
        backgroundColor: '#21a17b',
        width: '10px',
        opacity: 0.2
      },
      window: {
        width: 0,
        height: 0,
        heightAltCard: 0,
        heightAltered: 0,
        heightAltered1: 0,
        minHeightChatSection: 0
      }
    }
  },
  created () {
    this.user = Auth.getUserDetails()
  },
  mounted () {
    window.addEventListener('resize', this.handleResize)
    this.handleResize()
    let _this = this
    _this.loader = true
    const roomRef = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("chatRoom")
    roomRef.on("value", roomTemp => {
      let tempRoomObj = roomTemp.val()
      let tempRoom = []
      Object.keys(tempRoomObj).forEach(key => {
        let tempLastMessage = tempRoomObj[key]
        let last = Object.keys(tempLastMessage)[Object.keys(tempLastMessage).length-3]
        if(key.includes(_this.user.tokenChat)){
          if(!help.isDataEmpty(tempLastMessage[last])){
            tempRoom.push({
              roomSecureId: key,
              user_1: tempLastMessage['user-1'],
              user_2: tempLastMessage['user-2'],
              lastMessage: tempLastMessage[last]
            })
          }
        }
      })
      _this.room = tempRoom
      _this.loader = false
      if(_this.firstLoad){
        _this.roomId = _this.room[0].roomSecureId
        _this.firstLoad = false
      }
    })
    if(!help.isDataEmpty(_this.roomId)){
      const itemsRef = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("chatRoom/" + _this.roomId);
      itemsRef.on("value", snapshot => {
        let data = snapshot.val()
        let messages = []
        let user_1 = null
        let user_2 = null
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
    console.log('roomId',this.roomId)
  },
  unmounted () {
    window.removeEventListener('resize', this.handleResize)
  },
  methods: {
    doScrollBottomChat () {
      var element = document.getElementById('chatSection').getElementsByClassName("q-scrollarea__container")[0]
      element.scrollTop = element.scrollHeight
    },
    changePageForChat (item) {
      console.log('item', item)
      let _this = this
      _this.clicked = true
      _this.roomId = item.roomSecureId
      if(!help.isDataEmpty(_this.roomId)){
        const itemsRef = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("chatRoom/" + _this.roomId);
        itemsRef.on("value", snapshot => {
          let data = snapshot.val()
          let messages = []
          let user_1 = null
          let user_2 = null
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
            _this.doScrollBottomChat()
          }, 0)
        })
      } 
    },
    sendMessage(event) {
      this.tempMessageInput = this.messageInput
      this.messageInput = ''
      const message = {
        time: new Date().getTime(),
        username: this.user.fullName,
        message: this.tempMessageInput
      }
      if(help.isObjectEmpty(event)){
        if(this.tempMessageInput != "" && !/\\n\\r/.test(this.tempMessageInput) && !/^ *$/.test(this.tempMessageInput)){
          main
            .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
            .ref("chatRoom/" + this.roomId)
            .push(message)
          
          setTimeout(() => {
            _this.doScrollBottomChat()
          }, 0)

          this.tempMessageInput = ""
        }
      } else if(event.key == "Enter" && !event.shiftKey) {
      if(this.tempMessageInput != "" && !/\\n\\r/.test(this.tempMessageInput) && !/^ *$/.test(this.tempMessageInput)){
          main
            .database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/")
            .ref("chatRoom/" + this.roomId)
            .push(message)

          setTimeout(() => {
            _this.doScrollBottomChat()
          }, 0)
          this.tempMessageInput = ""
        }
      }
      setTimeout(() => {
        _this.doScrollBottomChat()
      }, 0)
      this.tempMessageInput = ""
    },
    handleResize () {
      this.window.width = window.innerWidth
      this.window.height = window.innerHeight
      this.window.heightRoom = window.innerHeight - (window.innerHeight * (22/100))
      this.window.heightAltered = window.innerHeight - (window.innerHeight * (40/100))
      this.window.heightAltered1 = window.innerHeight - (window.innerHeight * (45/100))
      this.window.minHeightChatSection = window.innerHeight - (window.innerHeight * (80/100))
    },
    changePage (url) {
      this.$router.push(url)
    }
  }
}
</script>