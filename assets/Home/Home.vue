<template>
  <div class="bienvenue-portail" v-if="first_visit">
    <div class="bienvenue-portail-layer layer-1 moveDown"></div>
    <div class="bienvenue-portail-layer layer-2"></div>
    <div class="bienvenue-portail-layer layer-3"></div>
    <div class="bienvenue-portail-title">
      <h1>Bienvenue</h1>
    </div>
  </div>
  <div v-if="!isLoaded" class="loading">
    <p>Chargement...</p>
  </div>
  <div style="height: 100%" v-else>
    <Count></Count>
    <div v-if="isGameOver" class="gameover">
      <div class="gameover-title">
        <h1>Perdu!</h1>
      </div>
      <div class="gameover-retry">
        <p v-on:click="retry">Réessayer?</p>
      </div>
    </div>
    <div v-else class="container-home">
      <div class="gameWon" v-if="allFound">
        <div>
          <div class="gameWon-text">
            <h3>Bravo! Vous avez trouvé tous les tableaux manquants!<br>Entretien...? :)</h3>
          </div>
          <div class="gameWon-retry">
            <p v-on:click="retry">Réinitialiser</p>
          </div>
        </div>
      </div>
      <div class="container-home-rules">
        <div class="container-home-rules-div">
          <p>Retrouvez les 3 tableaux manquants de cette collection <br>correspondants, au plus près, aux versets bibliques suivants.</p>
        </div>
      </div>
      <div class="toile-display">
        <div class="toile-display-flex">
          <tableau-home v-for="res in this.responseData" :key="res.id" :id="res.id" :image="res.image" :verse="res.verset" :reference="res.reference" :link="`/tableau/col/${res.id}`"></tableau-home>
        </div>
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
        allFound: false,
        first_visit: true
      };
    },
    mounted() {
      this.fetchData();
      this.firstVisited()
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
              this.isGameOver = response.data == 1 ? true : false;
              this.isLoaded = true;
            });
        axios.get("/all_found")
            .then(response => {
              if (response.data == 1){
                this.decrementCount();
                this.allFound = true;
                this.isLoaded = true;
              }
            })
      },
      firstVisited(){
        if (!localStorage.getItem("first-visit")) {
          localStorage.setItem('first-visit', "false");
          // animation
          this.welcomeAnimation();
        } else {
          this.first_visit = false;
        }
      },
      welcomeAnimation(){
        setTimeout(()=>{this.moveDown("layer-2")},500)
        setTimeout(()=>{this.moveDown("layer-3")},1000)
        setTimeout(()=>{this.fade("fadeIn")},1500)
        setTimeout(()=>{this.fade("fadeOut")},2500)
        setTimeout(()=>{this.moveUp("layer-3")},3000)
        setTimeout(()=>{this.moveUp("layer-2")},3500)
        setTimeout(()=>{this.moveUp("layer-1")},4000)
        setTimeout(()=>{this.first_visit = false},4500)
      },
      moveUp(selector){
        const el = document.querySelector(`.${selector}`);
        el.classList.remove("moveDown");
        el.classList.add("moveUp");
      },

      moveDown(selector){
        document.querySelector(`.${selector}`)
            .classList.add("moveDown");
      },
      fade(event){
        document.querySelector(".bienvenue-portail-title")
            .classList.add(event);
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