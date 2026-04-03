import { createRouter, createWebHistory } from 'vue-router'
import Directory from '../components/Directory.vue'


/**
 * Layouts are declared in ../App.vue
 */
export const router = createRouter({
    history: createWebHistory(),
    routes: [
        { path: '/:uuid', name: 'directory', component: Directory, meta: { layout: 'modal' }  },
    ]
})
