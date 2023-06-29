import { createApp } from 'vue';
import Tableau from './Tableau.vue';
import store from "./../store"
import Count from "./../Count/Count.vue";
import Footer from "../Footer/Footer.vue";

const app = createApp({
    template: `
        <count></count>
        <tableau :id="id"></tableau>
    `,
    data() {
        return {
            id: document.getElementById('app').dataset.id,
        };
    },
    components: {
        "count": Count,
        "tableau": Tableau,
        "app-footer": Footer
    },
});
app.use(store);

app.mount('#app');
