<template>
  <!-- component -->
  <div class="flex-1 p:2 sm:p-6 justify-between flex flex-col h-screen">
    <div class="flex sm:items-center justify-between py-3 border-b-2 border-gray-200">
      <div class="flex items-center space-x-4">
        <img
            src="https://static-cdn.jtvnw.net/jtv_user_pictures/22eefc0d-be20-4eee-8c09-f1eb6fba629b-profile_image-70x70.png"
            alt="" class="w-10 sm:w-16 h-10 sm:h-16 rounded-full">
        <div class="flex flex-col leading-tight">
          <div class="text-2xl mt-1 flex items-center">
            <span class="text-gray-700 mr-3">joeel561</span>
            <span class="text-green-500">
                  <svg width="10" height="10">
                     <circle cx="5" cy="5" r="5" fill="currentColor"></circle>
                  </svg>
               </span>
          </div>
          <span class="text-lg text-gray-600">Junior Developer</span>
        </div>
      </div>
    </div>
    <div id="messages"
         class="flex flex-col space-y-4 p-3 overflow-y-auto scrollbar-thumb-blue scrollbar-thumb-rounded scrollbar-track-blue-lighter scrollbar-w-2 scrolling-touch">
      <template v-for="message of messages">

        <div class="chat-message" v-if="!message.mine">
          <div class="flex items-end">
            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-2 items-start">
              <div><span class="px-4 py-2 rounded-lg inline-block rounded-bl-none bg-gray-300 text-gray-600">{{ message.data }}</span>
              </div>
            </div>
            <img
                src="https://images.unsplash.com/photo-1549078642-b2ba4bda0cdb?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144"
                alt="My profile" class="w-6 h-6 rounded-full order-1">
          </div>
        </div>

        <div class="chat-message" v-if="message.mine">
          <div class="flex items-end justify-end">
            <div class="flex flex-col space-y-2 text-xs max-w-xs mx-2 order-1 items-end">
              <div><span class="px-4 py-2 rounded-lg inline-block rounded-br-none bg-blue-600 text-white ">{{ message.data }}</span>
              </div>
            </div>
            <img
                src="https://images.unsplash.com/photo-1590031905470-a1a1feacbb0b?ixlib=rb-1.2.1&amp;ixid=eyJhcHBfaWQiOjEyMDd9&amp;auto=format&amp;fit=facearea&amp;facepad=3&amp;w=144&amp;h=144"
                alt="My profile" class="w-6 h-6 rounded-full order-2">
          </div>
        </div>
      </template>

    </div>
    <div class="border-t-2 border-gray-200 px-4 pt-4 mb-2 sm:mb-0">
      <div class="relative flex">
        <input v-model="chatMessage" type="text" placeholder="Write Something"
               class="w-full focus:outline-none focus:placeholder-gray-400 text-gray-600 placeholder-gray-600 pl-4 bg-gray-200 rounded-full py-3">
        <div class="absolute right-0 items-center inset-y-0 hidden sm:flex">
          <button
              @click="send()"
              type="button"
              class="inline-flex items-center justify-center rounded-full h-12 w-12 transition duration-500 ease-in-out text-white bg-blue-500 hover:bg-blue-400 focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                 class="h-6 w-6 transform rotate-90">
              <path
                  d="M10.894 2.553a1 1 0 00-1.788 0l-7 14a1 1 0 001.169 1.409l5-1.429A1 1 0 009 15.571V11a1 1 0 112 0v4.571a1 1 0 00.725.962l5 1.428a1 1 0 001.17-1.408l-7-14z"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>


</template>

<script setup>
import {ref} from "vue";

let messages = ref([]);
let chatMessage = ref("");

let websocket = new WebSocket('ws://localhost:8080')
websocket.onmessage = (e) => {
  messages.value.push({mine: false, 'data': e.data});
}

let send = () => {
  if (chatMessage.value.length > 0) {
    messages.value.push({mine: true, 'data': chatMessage.value});
    websocket.send(chatMessage.value);
    chatMessage.value = "";
  }
}

</script>

<style scoped>
.scrollbar-w-2::-webkit-scrollbar {
  width: 0.25rem;
  height: 0.25rem;
}

.scrollbar-track-blue-lighter::-webkit-scrollbar-track {
  --bg-opacity: 1;
  background-color: #f7fafc;
  background-color: rgba(247, 250, 252, var(--bg-opacity));
}

.scrollbar-thumb-blue::-webkit-scrollbar-thumb {
  --bg-opacity: 1;
  background-color: #edf2f7;
  background-color: rgba(237, 242, 247, var(--bg-opacity));
}

.scrollbar-thumb-rounded::-webkit-scrollbar-thumb {
  border-radius: 0.25rem;
}
</style>