import "./styles/app.css"
import { createApp } from 'vue';
import MyComponent from './Home/Home.vue';
import store from "./store";

const app = createApp({
    template: `
        <my-component></my-component>
    `,
    components: {
        "my-component": MyComponent,
    },
});
app.use(store);
app.mount('#app');
