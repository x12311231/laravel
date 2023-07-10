import './bootstrap';
import App from "./App.vue";
import { createApp } from 'vue';
import Index from "./views/Index.vue";

console.log('precognition')
let app = createApp(Index);
app.mount('#app')

