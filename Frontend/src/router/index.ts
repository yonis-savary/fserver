import { createRouter, createWebHistory } from 'vue-router'
import Home from '../components/Home.vue'


/**
 * Layouts are declared in ../App.vue
 */
export const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/', name: 'Home', component: Home, meta: { layout: 'modal' }  },
    ]
})
