<template>
  <header>
    <div class="header-toile-flex">
      <div class="header-toile-flex-div item">
        <figure>
          <a href="https://github.com/iamSamDiak" target="_blank"><img src="./../images/github.png"></a>
        </figure>
      </div>
      <div class="item" style="text-align: center">
        <h1><a href="/">La Toile</a></h1>
      </div>
      <div class="item" style="text-align: right">
        <p v-if="this.count > 1">{{ count }} essais restants...</p>
        <p v-else>{{ count }} essai restant...</p>
      </div>
    </div>
    <!-- Include any other header content here -->
  </header>
</template>


<script>
import { mapState, mapMutations } from 'vuex';
import axios from "axios";

export default {
  computed: {
    ...mapState(['count'])
  },
};
</script>