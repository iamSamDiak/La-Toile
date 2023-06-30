<template>
  <div v-if="!isLoaded" class="loading">
    <p>Chargement...</p>
  </div>
  <div v-else>
    <Count></Count>
    <div class="container-home">
      <div class="container-home-rules">
        <div class="container-home-rules-div">
          <p>{{ verse }}</p>
          <p>{{ reference }}</p>
        </div>
        <div class="container-home-rules-tip">
          <p>ASTUCE : Connaître le contexte du verset aide...</p>
        </div>
      </div>
      <div class="toile-display">
        <div class="toile-display-flex-tableau">
          <TableauChoix v-for="c in this.col" :parent_id="id" :id_3="c.id" :image="c.image" :res="c.reponse"></TableauChoix>
        </div>
      </div>
    </div>
    <div class="go-back">
      <a href="/"><p>Retour</p></a>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import TableauChoix from "./TableauChoix.vue";
  import {mapActions} from "vuex";
  import Count from "./../Count/Count.vue"

  export default {
    components: {
      TableauChoix, Count
    },
    props: ['id'],
    data() {
      return {
        isLoaded: false,
        responseData: null,
        id_2: "",
        verse: "",
        reference: "",
        col: []
      };
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      fetchData() {
        axios.get(`/masterpiece/${this.id}`)
            .then(response => {
              const { id, verset, reference , collection } = response.data;
              this.id_2 = id;
              this.verse = verset;
              this.reference = reference;
              this.col = collection;
              this.decrementCount()
              this.isLoaded = true
            })
            .catch(error => {
              console.error('Error:', error);
            });
      },
      ...mapActions(['updateCount']),
      decrementCount() {
        axios.get(`/get/count/`)
            .then(response => {
              const count = response.data;
              this.updateCount(count);
            })
            .catch(error => {
              console.error('Error:', error);
            });
      },
    }
  };
</script>