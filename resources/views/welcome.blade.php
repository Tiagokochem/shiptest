<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Teste Tailwind + Vue + Router + Pinia + i18n</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
  <!-- O Vue será montado aqui e dentro aparecerá o CepForm.vue -->
  <div id="app"></div>
</body>
</html>
