<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->string('cep', 20);
            $table->string('estado', 100);
            $table->string('cidade', 100);
            $table->string('bairro', 100);
            $table->string('endereco', 255);
            $table->string('numero', 50);
            $table->string('nome_contato', 150);
            $table->string('email_contato', 150);
            $table->string('telefone_contato', 50);
            $table->timestamps();
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
