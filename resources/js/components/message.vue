<template>
<div>
    <li class="list-group-item" :class="className"><slot></slot><span id="time">{{ time }}</span></li>
    <small class="badge float-end " :class="badgeClass" >{{user.name}}</small>
</div>
</template>

<script>

    export default {
        name: "message",
        props:[
            'color',
            'user',
            'time'
        ],
        computed:{
            className(){
                return 'list-group-item-'+this.color;
            },
            badgeClass(){
                return 'bg-'+this.color
            }
        }

    }
</script>

<style scoped>
    #time{
        font-size: 9px;
        margin-top: 10px;
        color: black;
    }
</style>
