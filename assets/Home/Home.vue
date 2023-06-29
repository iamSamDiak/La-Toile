<template>
  <div v-if="!isLoaded" class="loading">
    <p>Chargement...</p>
  </div>
  <div v-else class="container-home">
    <div v-if="isGameOver" class="title">
      <div>
        <h1>Game Over!</h1>
      </div>
      <div>
        <div>
          <p>Bon... entretien? ;)</p>
        </div>
        <button v-on:click="retry">Réessayer?</button>
      </div>
    </div>
    <div class="container-home-rules" v-if="!allFound">
      <div class="container-home-rules-div">
        <p>Retrouvez les 3 tableaux manquants de cette collection <br>avec pour indice des versets bibliques.</p>
      </div>
    </div>
    <div v-else>
      <div>
        <h1>Bravo!</h1>
      </div>
      <div>
        <h3>Vous avez trouvé tous les tableaux manquants! Entretien...? ^^</h3>
      </div>
      <div>
        <button v-on:click="retry">Réinitialiser</button>
      </div>
    </div>
    <div class="toile-display">
      <div class="toile-display-flex">
        <tableau-home v-for="res in this.responseData" :key="res.id" :id="res.id" :image="res.image" :verse="res.verset" :reference="res.reference" :link="`/tableau/col/${res.id}`"></tableau-home>
      </div>
    </div>
  </div>
</template>

<script>
  import TableauHome from "./TableauHome.vue";
  import axios from 'axios';
  import { mapActions } from "vuex";
  import Count from "./../Count/Count.vue";

  export default {
    components: {
      TableauHome, Count
    },
    data() {
      return {
        isLoaded: false,
        responseData: null,
        isGameOver: false,
        allFound: false
      };
    },
    mounted() {
      this.fetchData();
    },
    methods: {
      fetchData() {
        axios.get('/masterpiece')
            .then(response => {
              this.decrementCount();
              this.responseData = response.data.masterpiece;
              this.isLoaded = true;
            })
            .catch(error => {
              console.error('Error:', error);
            });
        axios.get("/is_game_over")
            .then(response => {
              this.decrementCount();
              this.isGameOver = response.data;
              this.isLoaded = true;
            });
        axios.get("/all_found")
            .then(response => {
              console.log(response.data)
              if (response.data == 1){
                this.decrementCount();
                this.allFound = true;
                this.isLoaded = true;
              }
            })
      },
      retry(){
        axios.get("/clear")
        window.location.href = "/"
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
  }
</script>