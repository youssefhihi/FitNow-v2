import './bootstrap';
import { createApp } from 'vue';
import router from './router.js';
import App from './layouts/App.vue';
import ExampleComponent from './components/ExampleComponent.vue';

const app = createApp(App); 

app.use(router);
app.component('example-component', ExampleComponent);

app.mount('#app');
