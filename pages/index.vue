<script setup>
import { ref, onMounted  } from 'vue';
import { Directus } from '@directus/sdk';


const directus = new Directus('https://directus.rubidiumweb.eu');


const listItems = ref([]);

async function publicData() {
	// GET DATA

	// We don't need to authenticate if the public role has access to some_public_collection.
	const publicData = await directus.items('section').readByQuery();
    var L=publicData.data;
    listItems.value = L;
    
    
}
publicData();
var show=false;


</script>

<template>
  <div>
  <section v-for="item in listItems" v-bind:key=item.id > 
      <h1>{{item.title}}</h1>
      <div> {{ item.template2 }}</div>
      
      <LazyMembreMember1 v-if="item.template2===1"/>
      <LazyMembreMember2 v-if="item.template2===2"/>
      <LazyMembreMember3 v-if="item.template2===5"/>

      <LazyPublicationPub1 v-if="item.template2===3"/>
      <LazyPublicationPub1 v-if="item.template2===4"/>
      <LazyPublicationPub3 v-if="item.template2===6"/>

      <LazyNewsNew1 v-if="item.template2===7"/>
      <LazyNewsNew2 v-if="item.template2===8"/>
      <LazyNewsNew3 v-if="item.template2===9"/>
      
  </section>
  </div>   
</template>

