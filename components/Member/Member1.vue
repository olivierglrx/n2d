<template>
  <body>
    <div class="container">
          <div class="wrapper flex flex-wrap justify-left gap-5">
            <div v-for="item in listItems" v-bind:key="item.id">
              <img :src="item.image" />
            </div>

      </div>
    </div>
  </body>
</template>

<script setup>
import { ref, onMounted } from "vue";
import { Directus } from "@directus/sdk";
const directus = new Directus("https://directus.rubidiumweb.eu");

const listItems = ref([]);

async function publicData() {
  // GET DATA

  // We don't need to authenticate if the public role has access to some_public_collection.
  const publicData = await directus.items("Members").readByQuery();

  publicData.data.forEach((element) => {
    element.image = "https://directus.rubidiumweb.eu/assets/" + element.image;
  });
  var L = publicData.data;
  listItems.value = L;
}
publicData();
</script>

<style scoped>
  .container {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: auto;
    width: 100%;
    background-size: cover;
    background-position: center;
    display: block;
    position: relative;
  }
  .container:hover .overlay {
    height: 100%;
  }
  .container img {
    height: 250px;
    width: 190px;
    object-fit: cover;
  }

</style>
