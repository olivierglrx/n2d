<template>
   <div>
   <p> This is New 1 template </p>
 
      
      <div v-for="news in listNews" v-bind:key=news.id>
         title :{{ news.title}}
        <div v-html="news.description">  </div>
      </div>    
      
   
 
   
   </div>
 </template>
 
 <script setup>
 import { ref, onMounted  } from 'vue';
 import { Directus } from '@directus/sdk';
 const directus = new Directus('https://directus.rubidiumweb.eu');
 
 
 const listNews = ref([]);
 async function publicData() {
    const directusNews = await directus.items('News').readByQuery();
    listNews.value = directusNews.data;
    console.log(directusNews.data)
 }
 publicData();
 </script>
 
 <style scoped>
 ul{margin: 10px;
 border:1px solid black;
 }
 li{
   list-style: square;
   padding:10px;
 }
 </style>