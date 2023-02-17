<template>
   <div>
   <p> This is Publication 3 template </p>
 
   <ul>     
      <li v-for="publication in listPublications" v-bind:key=publication.id>
         DOI :{{ publication.doi}}</li>
      
   </ul>
   </div>
 </template>
 
 <script setup>
 import { ref, onMounted  } from 'vue';
 import { Directus } from '@directus/sdk';
 const directus = new Directus('https://directus.rubidiumweb.eu');
 
 
 const listPublications = ref([]);
 async function publicData() {
    const directusPublications = await directus.items('publications').readByQuery();
    listPublications.value = directusPublications.data;
    
 }
 publicData();
 </script>
 
 <style scoped>
 ul{margin: 10px;
 border:1px solid blue;
 }
 li{
   list-style: square;
   padding:10px;
 }
 </style>