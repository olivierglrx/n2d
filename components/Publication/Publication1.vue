<template>
  <div>
  <p> This is Publication 1 template </p>

  <ul>     
     <li v-for="publication in listPublications" v-bind:key=publication.id>
        {{ publication.title}}</li>
     
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
   console.log(directusPublications.data)
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