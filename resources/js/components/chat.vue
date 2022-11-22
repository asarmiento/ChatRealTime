<template>
    <div class="offset-4 col-4 offset-sm-1 col-sm-6">
        <li class="list-group-item active">Chat Room <span class="badge  badge-pill badge-danger">@{{ numberOfUsers }}</span> </li>
        <div class="badge badge-pill badge-primary">@{{ typing }}</div>
        <ul class="list-group " v-chat-scroll>
            <message v-for="(value,index ) in chat.message"

                     :key="index"
                     :user="chat.user[index]"
                     :time="chat.time[index]"
                     :color="chat.color[index]"
            >{{value}}
            </message>
        </ul>
        <input type="text" class="form-control" placeholder="Escribir aquí..." v-model="message"
               @keyup.enter="send">
        <br>
        <a href='' class="btn btn-warning btn-sm" @click.prevent='deleteSession'>Delete Chats</a>
    </div>
</template>

<script>
    import Toaster from 'v-toaster'
    import 'v-toaster/dist/v-toaster.css'

    Vue.use(Toaster, {timeout: 5000})
    export default {
        name: "chat",
        data() {
            return {
                count: 0,
                message: '',
                chat: {
                    message: [],
                    user: [],
                    time: [],
                    color: []
                },
                typing: '',
                numberOfUsers: 0
            }
        }, watch: {
            message() {
                Echo.private('chat')
                    .whisper('typing', {
                        name: this.message
                    });
            }
        },
        methods: {
            send() {
                if (this.message.length != 0) {
                    this.chat.message.push(this.message)
                    this.chat.user.push({name: 'Yo'})
                    this.chat.color.push('success')
                    this.chat.time.push(this.getTime())

                }
                axios.post('/send', {message: this.message, chat:this.chat}).then(response => {

                    this.message = ''
                }).catch(err => {
                    console.log(err)
                })


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
                    console.log(e)
                }).listenForWhisper('escribiendo', (e) => {
                if (e.name != '') {
                    this.typing = 'escribiendo...'
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
                    // console.log(user);
                    this.$toaster.success(user.name + ' is joined the chat room');
                })
                .leaving((user) => {
                    this.numberOfUsers -= 1;
                    this.$toaster.warning(user.name + ' is leaved the chat room');
                });
        }
    }
</script>

<style scoped>

</style>
