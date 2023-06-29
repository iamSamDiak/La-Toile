<template>
  <div class="toile-display-flex-item">
    <div style="width: 100%">
      <input type="hidden" :value="id">
      <div class="toile-display-img" v-if="hasBeenFound">
        <a :href=link>
          <figure>
            <img src="./../images/toile-vide.png"/>
          </figure>
        </a>
      </div>
      <div class="toile-display-img" v-else>
        <figure>
          <img :src="`/build/images/${this.image}`" />
        </figure>
      </div>
    </div>
    <div class="toile-display-verse-ref">
      <p class="toile-display-verse">{{ verse }}</p>
      <p class="toile-display-ref">{{ reference }}</p>
    </div>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    props: {
      id: String,
      image: String,
      link: String,
      verse: String,
      reference: String,
    },
    data() {
      return {
        hasBeenFound: false
      }
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      fetchData() {
        axios.get(`/has_been_found/${this.id}`)
            .then(response => {
              if (response.data == 1){
                this.hasBeenFound = true;
              }
            })
            .catch(error => {
              console.error('Error:', error);
            });
      }
    }
  }
</script>