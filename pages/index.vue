<script setup>
import { ref } from "vue";
import { Directus } from "@directus/sdk";

const directus = new Directus("https://directus.rubidiumweb.eu");
const sections = ref([]);
const templates = ref([]);
async function publicData() {
  const sectionDirectus = await directus.items("Section").readByQuery();
  

  const templateDirectus = await directus.items("Template").readByQuery();
  templates.value=templateDirectus.data;
  sectionDirectus.data.forEach(element=> 
  {
    element['templateName']=templateDirectus.data[element.templateToUse-1].templateName;
  });
  sections.value = sectionDirectus.data;
}
publicData();



</script>

<template>
  <div>
    <section v-for="section in sections" :key="section.id">
      <h1>{{ section.title }}</h1>  
        <component :is="section.templateName"></component>
    </section>
  </div>
</template>

<style>
h1 { 
  display: block;
  font-size: 2em;
  margin-top: 0.67em;
  margin-bottom: 0.67em;
  font-weight: bold;
  text-align: center;
}
</style>