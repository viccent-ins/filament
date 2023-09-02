import { createApp } from 'vue';
import { createPinia } from 'pinia'
import App from './App.vue';
const pinia = createPinia();
import piniaPluginPersistedstate from 'pinia-plugin-persistedstate';
import router from './router/router';
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
createApp(App).use(pinia.use(piniaPluginPersistedstate)).use(router)
    .use(ElementPlus)
    .mount('#app');

