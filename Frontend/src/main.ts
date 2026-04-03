import { createApp } from 'vue'
import PrimeVue from 'primevue/config';
import Aura from '@primeuix/themes/aura';
import App from './App.vue'
import { router } from './router'
import './style.css'
import { createPinia } from 'pinia';

const app = createApp(App)
app.use(router)
app.use(PrimeVue, { theme: { preset: Aura }});
app.use(createPinia())
app.mount('#app')
