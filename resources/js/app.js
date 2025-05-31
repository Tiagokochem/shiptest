// resources/js/app.js
import '../css/app.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import router from './router'

import App from './App.vue'

const app = createApp(App)

// Registrar Pinia
app.use(createPinia())

// Registrar Vue Router
app.use(router)

// Montar o Vue na div #app
app.mount('#app')
