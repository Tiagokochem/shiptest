// resources/js/app.js
import '../css/app.css'

import { createApp } from 'vue'
import { createPinia } from 'pinia'
import { setupI18n } from './i18n'
import router from './router'

import App from './App.vue'

const app = createApp(App)

// Registrar Pinia
app.use(createPinia())

// Registrar Vue Router
app.use(router)

// Registrar vue-i18n
const i18n = setupI18n()
app.use(i18n)

// Montar o Vue na div #app
app.mount('#app')
