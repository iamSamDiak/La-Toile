<template>
  <div class="toile-display-flex-item">
    <div>
      <input :value="id_3" type="hidden">
      <div :id="id_3" class="toile-display-img">
        <figure>
          <div class="wrong-answer"></div>
          <img class="chosePainting" @click="chosePainting(res)" :src="imageSource" />
        </figure>
      </div>
    </div>
  </div>
</template>

<script>
  import axios from "axios";
  import { mapActions } from 'vuex';

  export default {
    props: {
      parent_id: String,
      id_3: "",
      image: "",
      res: ""
    },
    computed: {
      imageSource(){
        return require('./../images/' + this.image)
      }
    },
    data(){
      return{
        count: 0
      }
    },
    methods: {
      chosePainting(res){
        axios.post("/send_results", {res: this.res, id: this.parent_id})
            .then(response => {
              console.log(response.data);
              if (response.data === "Game over!" || response.data === "Bonne réponse!" || response.data === "Gagné!"){
                window.location.href = "/"
              } else {
                this.decrementCount();
                // CSS animation
                const clipping = document.querySelector("#\\3" + this.id_3 + " figure .wrong-answer");
                const contrast = document.querySelector("#\\3" + this.id_3 + " figure img");
                clipping.classList.add("add_clipping")
                contrast.classList.add("add_contrast")
                setTimeout(()=>{clipping.classList.remove("add_clipping")},1000)
                setTimeout(()=>{contrast.classList.remove("add_contrast")},1000)
              }
            })
            .catch(error => {
              // Handle any errors
              console.error(error);
            });
      },
      ...mapActions(['updateCount']),
      decrementCount() {
        axios.get(`/get/count/`)
            .then(response => {
              this.count = response.data;
              this.updateCount(this.count);
            })
            .catch(error => {
              console.error('Error:', error);
            });
      },
    }
  }
</script>