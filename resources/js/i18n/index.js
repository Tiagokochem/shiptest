// resources/js/i18n/index.js
import { createI18n } from 'vue-i18n'

// Mensagens em Português e Inglês
const messages = {
  pt: {
    form: {
      title: 'Cadastro de Contato',
      labels: {
        cep: 'CEP:',
        estado: 'Estado:',
        cidade: 'Cidade:',
        bairro: 'Bairro:',
        endereco: 'Endereço:',
        numero: 'Número:',
        nome_contato: 'Nome de Contato:',
        email_contato: 'Email de Contato:',
        telefone_contato: 'Telefone de Contato:',
      },
      placeholders: {
        cep: 'Digite o CEP (somente números)',
        estado: 'Preenchido automaticamente',
        cidade: 'Preenchido automaticamente',
        bairro: 'Preenchido automaticamente',
        endereco: 'Preenchido automaticamente',
        numero: 'Digite o número',
        nome_contato: 'Digite o nome',
        email_contato: 'Digite o e-mail',
        telefone_contato: 'Digite o telefone',
      },
      button: 'Salvar',
      alertSuccess: 'Veja o console do navegador para os dados do formulário.',
      alertCepNotFound: 'CEP não encontrado',
      alertCepError: 'Não foi possível buscar o CEP no momento',
    },
    
    list: {
      title: 'Listagem de Contatos',
      headers: {
        id: 'ID',
        nome: 'Nome',
        email: 'Email',
        telefone: 'Telefone',
        cep: 'CEP',
        cidade: 'Cidade',
        estado: 'Estado',
      },
      noRecords: 'Nenhum contato cadastrado.',
      exportButton: 'Exportar CSV',
      errorLoading: 'Não foi possível carregar os contatos.',
      errorExport: 'Erro ao exportar CSV.',
    },
  },
  en: {
    form: {
      title: 'Contact Registration',
      labels: {
        cep: 'ZIP Code:',
        estado: 'State:',
        cidade: 'City:',
        bairro: 'Neighborhood:',
        endereco: 'Address:',
        numero: 'Number:',
        nome_contato: 'Contact Name:',
        email_contato: 'Contact Email:',
        telefone_contato: 'Contact Phone:',
      },
      placeholders: {
        cep: 'Enter ZIP Code (numbers only)',
        estado: 'Autofilled',
        cidade: 'Autofilled',
        bairro: 'Autofilled',
        endereco: 'Autofilled',
        numero: 'Enter number',
        nome_contato: 'Enter name',
        email_contato: 'Enter email',
        telefone_contato: 'Enter phone',
      },
      button: 'Save',
      alertSuccess: 'Check the browser console for form data.',
      alertCepNotFound: 'ZIP Code not found',
      alertCepError: 'Could not fetch ZIP Code at the moment',
    },
    list: {
      title: 'Contacts List',
      headers: {
        id: 'ID',
        nome: 'Name',
        email: 'Email',
        telefone: 'Phone',
        cep: 'ZIP Code',
        cidade: 'City',
        estado: 'State',
      },
      noRecords: 'No contacts found.',
      exportButton: 'Export CSV',
      errorLoading: 'Unable to load contacts.',
      errorExport: 'Error exporting CSV.',
    },
  },
}

export function setupI18n() {
  // Detectar língua padrão via browser ou fallback para 'pt'
  const locale = navigator.language.startsWith('en') ? 'en' : 'pt'

  const i18n = createI18n({
    legacy: false,        // <-- aqui ativamos o modo Composition API 
    locale,
    fallbackLocale: 'pt',
    messages,
  })

  return i18n
}
