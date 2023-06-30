import { createApp } from 'vue';
import Tableau from './Tableau.vue';
import store from "./../store"
import Footer from "../Footer/Footer.vue";

const app = createApp({
    template: `
        <tableau :id="id"></tableau>
    `,
    data() {
        return {
            id: document.getElementById('app').dataset.id,
        };
    },
    components: {
        "tableau": Tableau,
        "app-footer": Footer
    },
});
app.use(store);

app.mount('#app');
