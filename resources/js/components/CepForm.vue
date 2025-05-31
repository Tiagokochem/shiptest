<!-- resources/js/components/CepForm.vue -->
<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
      <form
        @submit.prevent="onSubmit"
        class="w-full max-w-lg bg-white rounded-lg shadow-md p-6 space-y-4"
      >
        <h1 class="text-2xl font-bold text-gray-800 mb-4">
          Cadastro de Contato
        </h1>
  
        <!-- CEP -->
        <div class="flex flex-col">
          <label for="cep" class="mb-1 font-medium text-gray-700">CEP:</label>
          <input
            id="cep"
            type="text"
            v-model="form.cep"
            @blur="lookupCep"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite o CEP (somente números)"
          />
        </div>
  
        <!-- Estado -->
        <div class="flex flex-col">
          <label for="estado" class="mb-1 font-medium text-gray-700">Estado:</label>
          <input
            id="estado"
            type="text"
            v-model="form.estado"
            readonly
            class="border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Preenchido automaticamente"
          />
        </div>
  
        <!-- Cidade -->
        <div class="flex flex-col">
          <label for="cidade" class="mb-1 font-medium text-gray-700">Cidade:</label>
          <input
            id="cidade"
            type="text"
            v-model="form.cidade"
            readonly
            class="border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Preenchido automaticamente"
          />
        </div>
  
        <!-- Bairro -->
        <div class="flex flex-col">
          <label for="bairro" class="mb-1 font-medium text-gray-700">Bairro:</label>
          <input
            id="bairro"
            type="text"
            v-model="form.bairro"
            readonly
            class="border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Preenchido automaticamente"
          />
        </div>
  
        <!-- Endereço -->
        <div class="flex flex-col">
          <label for="endereco" class="mb-1 font-medium text-gray-700">Endereço:</label>
          <input
            id="endereco"
            type="text"
            v-model="form.endereco"
            readonly
            class="border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Preenchido automaticamente"
          />
        </div>
  
        <!-- Número -->
        <div class="flex flex-col">
          <label for="numero" class="mb-1 font-medium text-gray-700">Número:</label>
          <input
            id="numero"
            type="text"
            v-model="form.numero"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite o número"
          />
        </div>
  
        <!-- Nome do Contato -->
        <div class="flex flex-col">
          <label for="nome_contato" class="mb-1 font-medium text-gray-700"
            >Nome de Contato:</label
          >
          <input
            id="nome_contato"
            type="text"
            v-model="form.nome_contato"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite o nome"
          />
        </div>
  
        <!-- Email do Contato -->
        <div class="flex flex-col">
          <label for="email_contato" class="mb-1 font-medium text-gray-700"
            >Email de Contato:</label
          >
          <input
            id="email_contato"
            type="email"
            v-model="form.email_contato"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite o e-mail"
          />
        </div>
  
        <!-- Telefone do Contato -->
        <div class="flex flex-col">
          <label for="telefone_contato" class="mb-1 font-medium text-gray-700"
            >Telefone de Contato:</label
          >
          <input
            id="telefone_contato"
            type="text"
            v-model="form.telefone_contato"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            placeholder="Digite o telefone"
          />
        </div>
  
        <!-- Botão de Enviar -->
        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition-colors"
          >
            Salvar (apenas console.log hoje)
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { reactive } from 'vue'
  
  const form = reactive({
    cep: '',
    estado: '',
    cidade: '',
    bairro: '',
    endereco: '',
    numero: '',
    nome_contato: '',
    email_contato: '',
    telefone_contato: '',
  })
  
  async function lookupCep() {
    const rawCep = form.cep.replace(/\D/g, '')
    if (rawCep.length !== 8) {
      return
    }
    try {
      const resp = await fetch(`https://viacep.com.br/ws/${rawCep}/json/`)
      if (!resp.ok) {
        throw new Error('Erro na requisição ViaCEP')
      }
      const data = await resp.json()
      if (data.erro) {
        alert('CEP não encontrado')
        return
      }
      form.estado = data.uf || ''
      form.cidade = data.localidade || ''
      form.bairro = data.bairro || ''
      form.endereco = data.logradouro || ''
    } catch (error) {
      console.error('lookupCep error:', error)
      alert('Não foi possível buscar o CEP no momento')
    }
  }
  
  function onSubmit() {
    console.log('Dados do formulário:', { ...form })
    alert('Veja o console do navegador para os dados do formulário.')
  }
  </script>
  
  <style scoped>
  /* Sem estilos adicionais aqui, tudo via Tailwind */
  </style>
  