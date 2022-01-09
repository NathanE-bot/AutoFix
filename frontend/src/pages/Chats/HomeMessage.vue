<template>
    <q-page class="chat-page">
      <div class="room-section-gap" v-if="!help.isObjectEmpty(room)">
        <div class="room-section cursor-pointer" v-for="item in room" :key="item.roomSecureId" @click="changePage('/member/homemessage/roommessage/' + item.roomSecureId)">
          <div class="content-section relative-position">
            <span class="time-pos tf-capitalize" v-if="!help.isDataEmpty(item.lastMessage.time)">{{ help.defaultFormat(item.lastMessage.time, help.data().time_4) }}</span>
            <q-separator class="indicator mr-24" color="primary" vertical size="8px" />
            <q-avatar size="90px" style="background-color: #d9d9d9">
              <i class="fas fa-user grey-5 fs-50"></i>
            </q-avatar>
            <div class="d-flex flex-dir-col a-start ml-10">
              <div class="fs-18 fw-bold black_3">{{ user.role == '2' ? item.user_1 : item.user_2 }}</div>
              <div class="text-subtitle2 ml-4 mb-0 grey_1 fw-lightbold line-clamp-3" style="white-space: pre-line">
                {{ item.lastMessage.message }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="flex flex-dir-col flex-center" v-else>
        <img class="responsive_img" style="width: 55%" src="~assets/images/preset/no_chat_image.png" alt="">
        <span class="fs-30 txt-white fw-semibold mt-10">Please begin your chat to see your chat list</span>
      </div>
    </q-page>
</template>

<script>
/* eslint-disable */
import main from '../../main'
import help from '../../js/help'
import { LocalStorage } from 'quasar'

export default {
  data() {
    return {
      help,
      userName: "",
      name: null,
      showMessage: "",
      room: [],
      messagesView: [],
      user: LocalStorage.getItem('autoRepairUser').data.user
    };
  },
  mounted() {
    let _this = this
    const roomRef = main.database("https://autofix-1a7af-default-rtdb.asia-southeast1.firebasedatabase.app/").ref("chatRoom")
    roomRef.on("value", roomTemp => {
      let tempRoomObj = roomTemp.val()
      let tempRoom = []
      Object.keys(tempRoomObj).forEach(key => {
        let tempLastMessage = tempRoomObj[key]
        console.log(tempLastMessage)
        let last = Object.keys(tempLastMessage)[Object.keys(tempLastMessage).length-3]
        if(key.includes(_this.user.tokenChat)){
          tempRoom.push({
            roomSecureId: key,
            user_1: tempLastMessage['user-1'],
            user_2: tempLastMessage['user-2'],
            lastMessage: tempLastMessage[last]
          })
        }
      })
      _this.room = tempRoom
      console.log(_this.room)
    })
  },
  methods: {
    changePage (url) {
      this.$router.push(url)
    }
  }
};
</script>
