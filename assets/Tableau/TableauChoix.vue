<template>
  <div>
    <input :value="id_3" type="hidden">
    <img class="chosePainting" @click="chosePainting(res)" style="width: 30%" :src="image" />
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
    data(){
      return{
        count: 0
      }
    },
    methods: {
      chosePainting(res){
        console.log(res, this.id_3)
        axios.post("/send_results", {res: this.res, id: this.parent_id})
            .then(response => {
              console.log(response.data);
              if (response.data === "Game over!" || response.data === "Bonne réponse!" || response.data === "Gagné!"){
                window.location.href = "/"
              } else {
                this.decrementCount();
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