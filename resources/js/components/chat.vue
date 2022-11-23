<template>
    <div class="chat-box">
        <h1 class="chat-box-title ml-3">Friendly Chat <span class="badge  badge-pill badge-danger float-right"> @{{ numberOfUsers }}</span> </h1>
        <div class="badge badge-pill label-primary">{{ typing }}</div>
        <ul class="list-group " v-chat-scroll>
            <message v-for="(value,index ) in chat.message"
                     :key="index"
                     :user="chat.user[index]"
                     :time="chat.time[index]"
                     :color="chat.color[index]"
                     :txtAlin="chat.txtAlin[index]"
                     :txtFloat="chat.txtFloat[index]"
            >{{value}}
            </message>
        </ul>
        <input type="text" class="form-control" placeholder="Escribir aquí..." v-model="message"
               @keyup.enter="send">
        <br>

      <!--  <a href='' class="btn btn-warning btn-sm" @click.prevent='deleteSession'>Delete Chats</a>-->
    </div>
</template>

<script>
    import Toaster from 'v-toaster'
    import 'v-toaster/dist/v-toaster.css'
import message from "./message";
    Vue.use(Toaster, {timeout: 5000})
    export default {
        name: "chat",
        data() {
            return {
                message: '',
                chat: {
                    message: [],
                    user: [],
                    time: [],
                    txtAlin: [],
                    txtFloat: [],
                    color: []
                },
                typing: '',
                numberOfUsers: 0
            }
        }, watch: {
            message() {
                Echo.channel('chat').listenForWhisper(
                    'typing', {
                        name: this.message
                    });
            }
        },
        created(){
            this. getOldMessages()

        },
        methods: {
            send() {
                if (this.message.length != 0) {
                    this.chat.message.push(this.message)
                    this.chat.user.push( 'Yo')
                    this.chat.color.push('success')
                    this.chat.txtAlin.push('right')
                    this.chat.txtFloat.push('end')
                    this.chat.time.push(this.getTime())

                }
                let data = {message: this.message, chat:this.chat};
                this.message = ''
                axios.post('/send', data).then(response => {


                }).catch(err => {
                    console.log(err)
                })


            },
setAudio(){
    const audio = document.createElement("audio");
    audio.preload = "auto";
    audio.src = "http://chatapp.test/SD_ALERT_6.mp3";
    audio.play();

    document.body.appendChild(audio);
    return audio
},
            getTime() {
                let time = new Date();
                return time.getHours() + ':' + time.getMinutes();
            },
            getOldMessages() {
                axios.post('/getOldMessage')
                    .then(response => {
                        console.log(response);
                        if (response.data != '') {
                            this.chat = response.data;
                        }
                    })
                    .catch(error => {
                        console.log(error);
                    });
            },
            deleteSession() {
                axios.post('/deleteSession')
                    .then(response => this.$toaster.success('Chat history is deleted'));
            }
        },
        mounted() {
            Echo.channel('chat')
                .listen('ChatEvent', (e) => {
                    this.chat.message.push(e.message)
                    this.chat.user.push(e.user)
                    this.chat.color.push('warning')
                    this.chat.txtAlin.push('left')
                    this.chat.txtFloat.push('start')
                    this.chat.time.push(this.getTime())
                    this.setAudio()
                    axios.post('/saveToSession',{
                        chat : this.chat
                    })
                        .then(response => {
                        })
                        .catch(error => {
                            console.log(error);
                        });
                    console.log(e)
                }).listenForWhisper('typing', (e) => {
                    console.log(e)
                if (e.name != '') {
                    this.typing = 'typing...'
                } else {
                    this.typing = ''
                }
            });

            Echo.join(`chat`)
                .here((users) => {
                    this.numberOfUsers = users.length;
                })
                .joining((user) => {
                    this.numberOfUsers += 1;
                  //  this.setAudio()
                    this.$toaster.success(user.name + ' a ingresado al chat');
                })
                .leaving((user) => {
                    this.numberOfUsers -= 1;
                    //this.setAudio()
                    this.$toaster.warning(user.name + ' a salido del chat');
                });
        }
    }
</script>

<style scoped>

</style>
