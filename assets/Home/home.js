import { createApp } from 'vue';
import MyHome from './Home.vue';
import store from "../store";
import Count from "../Count/Count.vue"
import Footer from "../Footer/Footer.vue";

const app = createApp({
    template: `
      <count></count>
        <home></home>
    `,
    components: {
        "count": Count,
        "home": MyHome,
        "app-footer": Footer
    },
});
app.use(store);
app.mount('#app');
