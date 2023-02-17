<template>
    <div>
    <p> This is Member 3 template </p>
 
    <ul>     
       
       <li v-for="member in listMembers" v-bind:key=member.id>
          <div class="name">{{ member.last_name}}</div> </li>
       
    </ul>
    </div>
 </template>
 
 <script setup>
 import { ref, onMounted  } from 'vue';
 import { Directus } from '@directus/sdk';
 const directus = new Directus('https://directus.rubidiumweb.eu');
 
 
 const listMembers = ref([]);
 async function publicData() {
     // GET DATA
 
     // We don't need to authenticate if the public role has access to some_public_collection.
       const directusMembers = await directus.items('Members').readByQuery();
     
     
     directusMembers.data.forEach(element => {
       element.image='https://directus.rubidiumweb.eu/assets/'+element.image
     });
     listMembers.value = directusMembers.data;
 
 }
 publicData();
 </script>
 
 <style scoped>

 li{
    list-style: square;
    padding:10px;
 }

 .name{
    text-transform: uppercase;
 }
 </style>