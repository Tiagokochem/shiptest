{{-- resources/views/emails/contacts/created.blade.php --}}
@component('mail::message')
# Novo Contato Cadastrado

Um novo contato foi registrado em sua agenda:

- **ID:** {{ $contact->id }}
- **Nome:** {{ $contact->nome_contato }}
- **Email:** {{ $contact->email_contato }}
- **Telefone:** {{ $contact->telefone_contato }}
- **CEP:** {{ $contact->cep }}
- **Endereço:** {{ $contact->endereco }}, {{ $contact->numero }}, {{ $contact->bairro }} – {{ $contact->cidade }}, {{ $contact->estado }}

@component('mail::button', ['url' => url('/contacts')])
Ver Lista de Contatos
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
