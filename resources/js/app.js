// resources/js/app.js
import '../css/app.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { setupI18n } from './i18n'
import router from './router'

import App from './App.vue'

const app = createApp(App)

// Configurar Pinia
app.use(createPinia())

// Configurar Vue Router
app.use(router)

// Configurar vue-i18n
const i18n = setupI18n()
app.use(i18n)

// Montar o Vue na div #app
app.mount('#app')
