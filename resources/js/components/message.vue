<template>
<div>
    <li class="list-group-item " :class="className+' '+ txtAling+' '+ floatxt"><slot></slot><span id="time">{{ time }}</span></li>
    <small class="badge  " :class="badgeClass+' '+ floatxt" >{{user}}</small>
</div>
</template>

<script>

    export default {
        name: "message",
        props:[
            'color',
            'user',
            'time',
            'txtAlin',
            'txtFloat'
        ],
        computed:{
            className(){
                return 'list-group-item-'+this.color;
            },
            badgeClass(){
                return 'bg-'+this.color
            },
            txtAling(){
                return 'text-message-'+this.txtAlin
            },
            floatxt(){
                return 'float-'+this.txtFloat
            }
        }

    }
</script>

<style scoped>

</style>
