<script setup>
import { ref } from "vue";
import { Directus } from "@directus/sdk";

const directus = new Directus("https://directus.rubidiumweb.eu");

const listItems = ref([]);

async function publicData() {
  const publicData = await directus.items("section").readByQuery();
  var L = publicData.data;
  listItems.value = L;
}
publicData();
var show = false;
</script>

<template>
  <div>
    <section v-for="item in listItems" :key="item.id">
      <h1>{{ item.title }}</h1>
      <div>numero du template : {{ item.template2 }}</div>
      <component :is="'LazyMembreMember' + item.template2"></component>
      <component :is="'LazyPublicationPub' + item.template2"></component>
      <!-- <LazyMembreMember1 v-if="item.template2 === 1" /> -->
    </section>
  </div>
</template>
