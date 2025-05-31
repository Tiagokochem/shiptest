<!-- resources/js/components/CepForm.vue -->
<template>
    <div class="min-h-screen bg-gray-100 flex items-center justify-center p-4">
      <form
        @submit.prevent="onSubmit"
        class="w-full max-w-lg bg-white rounded-lg shadow-md p-6 space-y-4"
      >
        <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $t('form.title') }}</h1>
  
        <!-- Select de idioma -->
        <div class="flex justify-end mb-4">
          <select v-model="currentLocale" @change="changeLocale" class="border border-gray-300 rounded px-2 py-1">
            <option value="pt">Português</option>
            <option value="en">English</option>
          </select>
        </div>
  
        <!-- CEP -->
        <div class="flex flex-col">
          <label for="cep" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.cep') }}
          </label>
          <input
            id="cep"
            type="text"
            v-model="form.cep"
            @blur="lookupCep"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.cep')"
          />
        </div>
  
        <!-- Estado -->
        <div class="flex flex-col">
          <label for="estado" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.estado') }}
          </label>
          <input
            id="estado"
            type="text"
            v-model="form.estado"
            readonly
            class="border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.estado')"
          />
        </div>
  
        <!-- Cidade -->
        <div class="flex flex-col">
          <label for="cidade" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.cidade') }}
          </label>
          <input
            id="cidade"
            type="text"
            v-model="form.cidade"
            readonly
            class="border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.cidade')"
          />
        </div>
  
        <!-- Bairro -->
        <div class="flex flex-col">
          <label for="bairro" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.bairro') }}
          </label>
          <input
            id="bairro"
            type="text"
            v-model="form.bairro"
            readonly
            class="border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.bairro')"
          />
        </div>
  
        <!-- Endereço -->
        <div class="flex flex-col">
          <label for="endereco" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.endereco') }}
          </label>
          <input
            id="endereco"
            type="text"
            v-model="form.endereco"
            readonly
            class="border border-gray-300 rounded px-3 py-2 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.endereco')"
          />
        </div>
  
        <!-- Número -->
        <div class="flex flex-col">
          <label for="numero" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.numero') }}
          </label>
          <input
            id="numero"
            type="text"
            v-model="form.numero"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.numero')"
          />
        </div>
  
        <!-- Nome do Contato -->
        <div class="flex flex-col">
          <label for="nome_contato" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.nome_contato') }}
          </label>
          <input
            id="nome_contato"
            type="text"
            v-model="form.nome_contato"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.nome_contato')"
          />
        </div>
  
        <!-- Email do Contato -->
        <div class="flex flex-col">
          <label for="email_contato" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.email_contato') }}
          </label>
          <input
            id="email_contato"
            type="email"
            v-model="form.email_contato"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.email_contato')"
          />
        </div>
  
        <!-- Telefone do Contato -->
        <div class="flex flex-col">
          <label for="telefone_contato" class="mb-1 font-medium text-gray-700">
            {{ $t('form.labels.telefone_contato') }}
          </label>
          <input
            id="telefone_contato"
            type="text"
            v-model="form.telefone_contato"
            class="border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
            :placeholder="$t('form.placeholders.telefone_contato')"
          />
        </div>
  
        <!-- Botão de Enviar -->
        <div class="flex justify-end">
          <button
            type="submit"
            class="bg-blue-600 text-white font-semibold px-4 py-2 rounded hover:bg-blue-700 transition-colors"
          >
            {{ $t('form.button') }}
          </button>
        </div>
      </form>
    </div>
  </template>
  
  <script setup>
  import { reactive, ref } from 'vue'
  import { useI18n } from 'vue-i18n'
  
  const { locale, t } = useI18n()
  
  // Controle do locale selecionado (para o dropdown)
  const currentLocale = ref(locale.value)
  
  // Reativo para armazenar os campos do formulário
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
  
  // Função para trocar o idioma ao selecionar no dropdown
  function changeLocale() {
    locale.value = currentLocale.value
  }
  
  /**
   * Autocomplete do CEP via ViaCEP
   */
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
        alert(t('form.alertCepNotFound'))
        return
      }
      form.estado = data.uf || ''
      form.cidade = data.localidade || ''
      form.bairro = data.bairro || ''
      form.endereco = data.logradouro || ''
    } catch (error) {
      console.error('lookupCep error:', error)
      alert(t('form.alertCepError'))
    }
  }
  
  /**
   * Submissão de exemplo (só console.log)
   */
  function onSubmit() {
    console.log('Dados do formulário:', { ...form })
    alert(t('form.alertSuccess'))
  }
  </script>
  
  <style scoped>
  /* Nenhum estilo adicional — tudo via Tailwind */
  </style>
  