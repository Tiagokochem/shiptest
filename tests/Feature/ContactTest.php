<?php

namespace Tests\Feature;

use App\Jobs\SendContactCreatedEmail;
use App\Mail\ContactCreatedNotification;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 11. Teste unitário para a listagem (GET /api/contacts)
     */
    public function test_can_list_contacts()
    {
        // Cria 3 contatos usando factory
        Contact::factory()->count(3)->create();

        // Requisição GET
        $response = $this->getJson('/api/contacts');

        // Deve retornar 200 OK
        $response->assertStatus(200);

        // Deve retornar exatamente 3 registros
        $response->assertJsonCount(3);

        // Verificar estrutura mínima do JSON
        $response->assertJsonStructure([
            '*' => [
                'id',
                'cep',
                'estado',
                'cidade',
                'bairro',
                'endereco',
                'numero',
                'nome_contato',
                'email_contato',
                'telefone_contato',
                'created_at',
                'updated_at',
            ],
        ]);
    }

    /**
     * 12. Teste unitário para o cadastro (POST /api/contacts)
     */
    public function test_can_create_contact_and_dispatch_email_job()
    {
        // Faze de fila para testar que o job foi enfileirado
        Queue::fake();

        // Dados válidos para criar um contato
        $payload = [
            'cep'             => '01001000',
            'estado'          => 'SP',
            'cidade'          => 'São Paulo',
            'bairro'          => 'Sé',
            'endereco'        => 'Praça da Sé',
            'numero'          => '100',
            'nome_contato'    => 'Test User',
            'email_contato'   => 'test@example.com',
            'telefone_contato' => '11999998888',
        ];

        // Requisição POST
        $response = $this->postJson('/api/contacts', $payload);

        // Deve retornar 201 Created
        $response->assertStatus(201);

        // Verificar que o contato existe no banco
        $this->assertDatabaseHas('contacts', [
            'email_contato' => 'test@example.com',
            'nome_contato'  => 'Test User',
        ]);

        // Verificar que o job de envio de e-mail foi enfileirado na fila back_emails
        Queue::assertPushed(SendContactCreatedEmail::class, function ($job) {
            return $job->queue === 'back_emails';
        });

        // Verificar retorno JSON inclui as mesmas chaves
        $response->assertJsonStructure([
            'id',
            'cep',
            'estado',
            'cidade',
            'bairro',
            'endereco',
            'numero',
            'nome_contato',
            'email_contato',
            'telefone_contato',
            'created_at',
            'updated_at'
        ]);
    }

    /**
     * 13. Teste unitário para a edição (PUT /api/contacts/{id})
     */
    public function test_can_update_contact()
    {
        // Cria um contato
        $contact = Contact::factory()->create([
            'nome_contato'  => 'Original Name',
            'email_contato' => 'original@example.com',
        ]);

        // Dados atualizados
        $payload = [
            'cep'             => $contact->cep,
            'estado'          => $contact->estado,
            'cidade'          => $contact->cidade,
            'bairro'          => $contact->bairro,
            'endereco'        => $contact->endereco,
            'numero'          => $contact->numero,
            'nome_contato'    => 'Updated Name',
            'email_contato'   => 'updated@example.com',
            'telefone_contato' => $contact->telefone_contato,
        ];

        // Requisição PUT
        $response = $this->putJson("/api/contacts/{$contact->id}", $payload);

        // Deve retornar 200 OK
        $response->assertStatus(200);

        // Verifica no banco que o contato foi atualizado
        $this->assertDatabaseHas('contacts', [
            'id'            => $contact->id,
            'nome_contato'  => 'Updated Name',
            'email_contato' => 'updated@example.com',
        ]);
    }

    /**
     * 14. Teste unitário para a deleção (DELETE /api/contacts/{id})
     */
    public function test_can_delete_contact()
    {
        // Cria um contato
        $contact = Contact::factory()->create();

        // Requisição DELETE
        $response = $this->deleteJson("/api/contacts/{$contact->id}");

        // Deve retornar 204 No Content
        $response->assertStatus(204);

        // Verifica que não existe mais no banco
        $this->assertDatabaseMissing('contacts', [
            'id' => $contact->id,
        ]);
    }

    /**
     * 15. Teste unitário para a exportação para CSV (POST /api/contacts/export)
     */
    public function test_can_export_contacts_to_csv()
    {
        // Cria três contatos
        $contacts = Contact::factory()->count(3)->create();

        $ids = $contacts->pluck('id')->toArray();

        // Requisição POST para exportar CSV
        $response = $this->postJson('/api/contacts/export', [
            'ids' => $ids,
        ]);

        // Deve retornar 200 OK e Content-Type 'text/csv'
        $response->assertStatus(200)
            ->assertHeader('Content-Type', 'text/csv; charset=UTF-8');

        // Verifica que o conteúdo retornado é CSV (inicia com o cabeçalho)
        $content = $response->streamedContent();
        $this->assertStringContainsString(
            'ID,CEP,Estado,Cidade,Bairro,Endereço,Número,"Nome de Contato","Email de Contato","Telefone de Contato","Criado em","Atualizado em"',
            $content
        );
    }

    /**
     * 16. Teste unitário para o disparo do e-mail na fila
     */
    public function test_contact_creation_dispatches_email_job()
    {
        // Fazemos fake na fila e no Mail
        Queue::fake();
        Mail::fake();

        // Cria o contato via POST
        $payload = Contact::factory()->make()->toArray();
        $response = $this->postJson('/api/contacts', $payload);

        // 1) Verifica que o contato foi criado
        $response->assertStatus(201);

        // 2) Verifica que o Job foi despachado para a fila back_emails
        Queue::assertPushed(SendContactCreatedEmail::class, function ($job) {
            return $job->queue === 'back_emails';
        });


        // Agora processamos manualmente o Job para verificar o envio de e-mail
        $job = new SendContactCreatedEmail(Contact::findOrFail($response->json('id')));
        $job->handle(); // Executa o handle sem passar pelo worker

        // 3) Verifica que o Mailable foi enviado para o endereço correto
        Mail::assertSent(ContactCreatedNotification::class, function ($mail) {
            return $mail->hasTo(env('NOTIFICATION_MAIL'));
        });
    }
}
