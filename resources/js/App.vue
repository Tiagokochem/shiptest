<!-- resources/js/App.vue -->
<template>
  <div>
    <!-- Navegação fixa -->
    <nav class="bg-white shadow-md p-4 flex justify-center space-x-4">
      <!-- router-link muda a rota sem recarregar a página -->
      <router-link to="/" class="text-blue-600 hover:underline">
        {{ $t('form.title') }}
      </router-link>
      <router-link to="/contacts" class="text-blue-600 hover:underline">
        {{ $t('list.title') }}
      </router-link>
    </nav>

    <!-- Área onde o Vue Router irá injetar CepForm ou ContactsList -->
    <router-view />
  </div>
</template>

<script setup>
// Nada a declarar aqui, pois já registramos router e i18n em app.js
</script>

<style>
/* Você pode deixar vazio ou adicionar estilos globais se quiser */
</style>
