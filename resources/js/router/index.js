// resources/js/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import CepForm from '../components/CepForm.vue'
import ContactsList from '../components/ContactsList.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: CepForm,
  },
  // Futuramente, poderemos adicionar rotas como “/lista”, “/editar/:id” etc.
  {
    path: '/contacts',
    name: 'ContactsList',
    component: ContactsList,
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
