<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'cep',
        'estado',
        'cidade',
        'bairro',
        'endereco',
        'numero',
        'nome_contato',
        'email_contato',
        'telefone_contato',
    ];
}
