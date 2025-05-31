<!-- resources/js/components/ContactsList.vue -->
<template>
    <div class="min-h-screen bg-gray-100 p-4">
      <h1 class="text-2xl font-bold text-gray-800 mb-4">{{ $t('list.title') }}</h1>
  
      <!-- Tabela de contatos -->
      <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table class="min-w-full table-auto">
          <thead class="bg-gray-200">
            <tr>
              <th class="px-4 py-2">
                <input
                  type="checkbox"
                  v-model="selectAll"
                  @change="toggleSelectAll"
                />
              </th>
              <th class="px-4 py-2">{{ $t('list.headers.id') }}</th>
              <th class="px-4 py-2">{{ $t('list.headers.nome') }}</th>
              <th class="px-4 py-2">{{ $t('list.headers.email') }}</th>
              <th class="px-4 py-2">{{ $t('list.headers.telefone') }}</th>
              <th class="px-4 py-2">{{ $t('list.headers.cep') }}</th>
              <th class="px-4 py-2">{{ $t('list.headers.cidade') }}</th>
              <th class="px-4 py-2">{{ $t('list.headers.estado') }}</th>
              <!-- Adicione outras colunas conforme necessidade -->
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="contact in contacts"
              :key="contact.id"
              class="border-t hover:bg-gray-50"
            >
              <td class="px-4 py-2 text-center">
                <input
                  type="checkbox"
                  :value="contact.id"
                  v-model="selectedIds"
                />
              </td>
              <td class="px-4 py-2">{{ contact.id }}</td>
              <td class="px-4 py-2">{{ contact.nome_contato }}</td>
              <td class="px-4 py-2">{{ contact.email_contato }}</td>
              <td class="px-4 py-2">{{ contact.telefone_contato }}</td>
              <td class="px-4 py-2">{{ contact.cep }}</td>
              <td class="px-4 py-2">{{ contact.cidade }}</td>
              <td class="px-4 py-2">{{ contact.estado }}</td>
            </tr>
            <tr v-if="contacts.length === 0">
              <td class="px-4 py-2 text-center text-gray-500" colspan="8">
                {{ $t('list.noRecords') }}
              </td>
            </tr>
          </tbody>
        </table>
      </div>
  
      <!-- Botão Exportar CSV -->
      <div class="mt-4 flex justify-end">
        <button
          @click="exportCsv"
          :disabled="selectedIds.length === 0"
          class="bg-green-600 text-white font-semibold px-4 py-2 rounded hover:bg-green-700 disabled:opacity-50 transition-colors"
        >
          {{ $t('list.exportButton') }}
        </button>
      </div>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted, watch } from 'vue'
  import axios from 'axios'
  import { useI18n } from 'vue-i18n'
  
  // Setup i18n
  const { t } = useI18n()
  
  // Reactive state
  const contacts = ref([])
  const selectedIds = ref([])
  const selectAll = ref(false)
  
  // Ao montar o componente, buscar todos os contatos
  onMounted(async () => {
    await fetchContacts()
  })
  
  // Função para buscar contatos da API
  async function fetchContacts() {
    try {
      const response = await axios.get('/api/contacts')
      contacts.value = response.data
    } catch (error) {
      console.error('Erro ao carregar contatos:', error)
      alert(t('list.errorLoading'))
    }
  }
  
  // Sempre que “selectAll” mudar, atualizar selectedIds
  watch(selectAll, (newVal) => {
    if (newVal) {
      selectedIds.value = contacts.value.map((c) => c.id)
    } else {
      selectedIds.value = []
    }
  })
  
  // Ao selecionar manualmente checkboxes, atualizar selectAll
  watch(selectedIds, (newIds) => {
    if (newIds.length === contacts.value.length && contacts.value.length > 0) {
      selectAll.value = true
    } else {
      selectAll.value = false
    }
  })
  
  // Função para alternar todos
  function toggleSelectAll() {
    if (selectAll.value) {
      selectedIds.value = contacts.value.map((c) => c.id)
    } else {
      selectedIds.value = []
    }
  }
  
  // Exportar CSV: envia POST /api/contacts/export com { ids: [...] }
  async function exportCsv() {
    if (selectedIds.value.length === 0) return
  
    try {
      const response = await axios.post(
        '/api/contacts/export',
        { ids: selectedIds.value },
        { responseType: 'blob' }
      )
  
      // Criar um Blob e forçar o download
      const blob = new Blob([response.data], { type: 'text/csv;charset=utf-8;' })
      const url = URL.createObjectURL(blob)
      const link = document.createElement('a')
      link.href = url
  
      // Usar o mesmo nome de arquivo gerado pelo backend
      const timestamp = new Date().toISOString().replace(/[:.-]/g, '')
      link.setAttribute('download', `contacts_${timestamp}.csv`)
      document.body.appendChild(link)
      link.click()
      document.body.removeChild(link)
    } catch (error) {
      console.error('Erro ao exportar CSV:', error)
      alert(t('list.errorExport'))
    }
  }
  </script>
  
  <style scoped>
  /* Nenhum estilo extra; tudo via Tailwind */
  </style>
  