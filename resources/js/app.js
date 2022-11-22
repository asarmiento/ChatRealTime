
require('./bootstrap');

window.Vue = require('vue').default;

import VueChatScroll from "vue-chat-scroll";
Vue.use(VueChatScroll)

Vue.component('message', require('./components/message.vue').default);
Vue.component('chat', require('./components/chat.vue').default);
Vue.component('registerUser', require('./components/register.vue').default);


const app = new Vue({
    el:"#app",

});

/*
import { createApp } from 'vue'

createApp({
    data() {
        return {
            count: 0,
            message:'',
            chat:{
                message:[]
            }
        }
    },
    methods:{
        send(){
            if(this.message.length != 0){
                this.chat.message.push(this.message)
             this.message=''
            }


        }
    }
}).mount('#app')*/
