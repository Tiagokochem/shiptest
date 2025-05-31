<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    // 1) Autorizar qualquer usuário (sem autenticação)
    public function authorize(): bool
    {
        return true;
    }

    // 2) Regras de validação
    public function rules(): array
    {
        return [
            'cep'             => ['required', 'string', 'regex:/^\d{5}-?\d{3}$/'],
            'estado'          => ['required', 'string', 'max:100'],
            'cidade'          => ['required', 'string', 'max:100'],
            'bairro'          => ['required', 'string', 'max:100'],
            'endereco'        => ['required', 'string', 'max:255'],
            'numero'          => ['required', 'string', 'max:50'],
            'nome_contato'    => ['required', 'string', 'max:150'],
            'email_contato'   => ['required', 'email', 'max:150'],
            'telefone_contato'=> ['required', 'string', 'max:50'],
        ];
    }

    // 3) Mensagens personalizadas (opcional)
    public function messages(): array
    {
        return [
            'cep.required'              => 'O campo CEP é obrigatório.',
            'cep.regex'                 => 'O CEP precisa ter 8 dígitos numéricos.',
            'estado.required'           => 'O campo Estado é obrigatório.',
            'cidade.required'           => 'O campo Cidade é obrigatório.',
            'bairro.required'           => 'O campo Bairro é obrigatório.',
            'endereco.required'         => 'O campo Endereço é obrigatório.',
            'numero.required'           => 'O campo Número é obrigatório.',
            'nome_contato.required'     => 'O campo Nome de Contato é obrigatório.',
            'email_contato.required'    => 'O campo Email de Contato é obrigatório.',
            'email_contato.email'       => 'O Email de Contato deve ser um e-mail válido.',
            'telefone_contato.required' => 'O campo Telefone de Contato é obrigatório.',
        ];
    }
}
