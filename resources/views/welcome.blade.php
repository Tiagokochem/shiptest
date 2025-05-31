<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Teste Tailwind + Vue</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="bg-gray-500">
    <h1 class="text-2xl font-bold text-green-600">Teste direto no Blade</h1>
    <div
      id="app"
      class="min-h-screen flex items-center justify-center"
    ></div>
  </body>
</html>
