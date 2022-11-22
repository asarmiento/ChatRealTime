<template>
    <div class="offset-md-4 col-4">
        <div class="form-group">
            <label>Nombre Completo</label>
            <input type="text" v-model="data.name" class="form-control">
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="text" v-model="data.email" class="form-control">
        </div>
        <div class="form-group m-3 text-center">
            <a @click="registerUser" class="btn btn-success">iniciar Chat</a>
        </div>
    </div>
</template>

<script>
    export default {
        name: "registerUser",
        data(){
            return{
                data:{
                    name:'',
                    email:'',
                    password:'password',
                    password_confirmation:'password',
                },

            }
        },
        methods:{

            registerUser(){
                axios.post('/store-register-user',this.data).then(response=>{
document.location ='/'
                });


            }
        }
    }
</script>

<style scoped>

</style>
