# ShipSmart - Laravel + Vue Test Project

Este projeto é um teste técnico fullstack utilizando **Laravel 12**, **Vue 3**, **Vite**, **Laravel Sail (Docker)** e integração com **Fila + Jobs + CSV + Testes**.

---

## ✅ Funcionalidades Implementadas

1. **Formulário com busca de endereço via CEP**
2. **Persistência de dados de contatos no banco de dados**
3. **Listagem de contatos com checkbox para seleção**
4. **Exportação dos contatos selecionados para CSV**
5. **Disparo de e-mail assíncrono com fila (Job) após cadastro de contato**
6. **Testes automatizados (Feature + Unit) para cada funcionalidade**
7. **Integração com fila 'database' via Laravel Queue**
8. **Ambiente dockerizado com Laravel Sail**

---

## 🚀 Tecnologias Usadas

- Laravel 12.x
- Vue 3 (com Composition API)
- Vite
- Laravel Sail (Docker Compose)
- Axios
- Tailwind CSS
- Fila com `database`
- Banco de dados MySQL (via container)
- Testes com `php artisan test`

---

## 🔧 Como rodar o projeto

### 1. Clone o repositório
```bash
git clone https://github.com/seu-usuario/shipsmart-test.git
cd shipsmart-test
```

### 1.1 Instalar as dependências com Composer (usando Docker):

docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php84-composer:latest \
    composer install --ignore-platform-reqs

### 2. Copie o `.env` de exemplo e edite se necessário
```bash
cp .env.example .env
```

### 3. Suba os containers com Sail
```bash
./vendor/bin/sail up -d
```

> A primeira vez pode demorar para instalar dependências PHP e JS.

### 4. Instale dependências JS
```bash
./vendor/bin/sail npm install
```

### 5. Rode o Vite para desenvolvimento
```bash
./vendor/bin/sail npm run dev
```

### 6. Rode as migrations e configure a fila
```bash
./vendor/bin/sail artisan migrate
./vendor/bin/sail artisan queue:table
./vendor/bin/sail artisan migrate
```

### 7. Inicie o worker da fila
```bash
./vendor/bin/sail artisan queue:work
```

---

## 🧪 Testes

Para rodar os testes unitários e de feature:

```bash
./vendor/bin/sail artisan test
```

Testes incluídos:

- Cadastro de contato
- Edição de contato
- Deleção de contato
- Exportação de contatos para CSV
- Disparo de e-mail para fila
- Listagem de contatos

---

## 📁 Estrutura Principal

```
├── app/
│   ├── Http/
│   │   ├── Controllers/Api/ContactController.php
│   │   └── Requests/StoreContactRequest.php
│   ├── Jobs/SendContactCreatedEmail.php
│   ├── Models/Contact.php
│   ├── Repositories/
│   ├── Services/
├── resources/js/
│   ├── components/
│   │   ├── CepForm.vue
│   │   └── ContactsList.vue
│   ├── router/index.js
│   └── app.js
├── routes/api.php
├── tests/Feature/ContactTest.php
├── docker-compose.yml
```

---

## 📧 Disparo de Email

O job `SendContactCreatedEmail` é despachado automaticamente após o cadastro de contato e vai para a fila `back_emails`. Você pode monitorar com:

```bash
./vendor/bin/sail artisan queue:work
```

---

## 👨‍💻 Autor

**Tiago Kochem**  
📧 tiagok989@gmail.com  
🔗 [LinkedIn](https://linkedin.com/in/tiago-kochem) | [GitHub](https://github.com/tiagokochem)

---

## 📝 Observações

- O projeto utiliza apenas **MySQL**, inclusive para testes.
- O `.env` já está configurado para funcionar com Laravel Sail.

---

Feito com ❤️ para avaliação .