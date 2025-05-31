<?php

use Illuminate\Support\Facades\Route;

// Rota principal (quando acessar “/”), carrega a view do Vue
Route::view('/', 'welcome');

// Rota “catch-all”: qualquer outro caminho que NÃO comece com “api/” (ou não seja asset, etc.)
// será enviado para a mesma view “welcome” e deixaremos o Vue Router tratar a rota.
Route::view('/{any}', 'welcome')
    ->where('any', '.*');
