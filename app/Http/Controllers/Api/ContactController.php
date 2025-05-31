<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Services\ContactServiceInterface;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    protected ContactServiceInterface $service;

    public function __construct(ContactServiceInterface $service)
    {
        $this->service = $service;
    }

    /**
     * GET /api/contacts
     */
    public function index(): JsonResponse
    {
        $contacts = $this->service->list();
        return response()->json($contacts);
    }

    /**
     * POST /api/contacts
     */
    public function store(StoreContactRequest $request): JsonResponse
    {
        // $request->validated() já retorna apenas os campos validados
        $contact = $this->service->create($request->validated());
        return response()->json($contact, 201);
    }

    /**
     * GET /api/contacts/{id}
     */
    public function show(int $id): JsonResponse
    {
        $contact = $this->service->get($id);
        return response()->json($contact);
    }

    /**
     * PUT/PATCH /api/contacts/{id}
     */
    public function update(StoreContactRequest $request, int $id): JsonResponse
    {
        $updated = $this->service->update($id, $request->validated());
        return response()->json($updated);
    }

    /**
     * DELETE /api/contacts/{id}
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }

      /**
     * POST /api/contacts/export
     * Recebe um array de IDs e retorna um CSV com esses contatos.
     */
    public function exportCsv(Request $request)
    {
        // Validar que 'ids' seja um array de inteiros
        $validated = $request->validate([
            'ids' => ['required', 'array'],
            'ids.*' => ['integer', 'exists:contacts,id'],
        ]);

        $ids = $validated['ids'];

        // Buscar os contatos correspondentes
        $contacts = Contact::whereIn('id', $ids)->get();

        // Definir os cabeçalhos do CSV
        $columns = [
            'ID',
            'CEP',
            'Estado',
            'Cidade',
            'Bairro',
            'Endereço',
            'Número',
            'Nome de Contato',
            'Email de Contato',
            'Telefone de Contato',
            'Criado em',
            'Atualizado em',
        ];

        // Criar resposta “streamed” para gerar CSV sob demanda
        $callback = function() use ($contacts, $columns) {
            $file = fopen('php://output', 'w');
            // Cabeçalho
            fputcsv($file, $columns);

            // Linhas
            foreach ($contacts as $c) {
                fputcsv($file, [
                    $c->id,
                    $c->cep,
                    $c->estado,
                    $c->cidade,
                    $c->bairro,
                    $c->endereco,
                    $c->numero,
                    $c->nome_contato,
                    $c->email_contato,
                    $c->telefone_contato,
                    $c->created_at->toDateTimeString(),
                    $c->updated_at->toDateTimeString(),
                ]);
            }

            fclose($file);
        };

        // Montar a resposta com headers para download
        $filename = 'contacts_export_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return new StreamedResponse($callback, 200, $headers);
    }
}
