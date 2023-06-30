import { createApp } from 'vue';
import MyHome from './Home.vue';
import store from "../store";
import Footer from "../Footer/Footer.vue";

const app = createApp({
    template: `
        <home></home>
    `,
    components: {
        "home": MyHome,
        "app-footer": Footer
    },
});
app.use(store);
app.mount('#app');