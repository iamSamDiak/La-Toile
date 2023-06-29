import "./styles/app.css"
import { createApp } from 'vue';
import MyComponent from './Home/Home.vue';
import Count from "./Count/Count.vue";
import store from "./store";

const app = createApp({
    template: `
        <count></count>
        <my-component></my-component>
    `,
    components: {
        "count": Count,
        "my-component": MyComponent,
    },
});
app.use(store);
app.mount('#app');
