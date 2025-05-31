<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;                         // <–– importar o Model Contact
use App\Services\ContactServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;                    // <–– importar Request
use Illuminate\Support\Facades\Response;         // <–– para streamDownload

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
        // 1) Validar que 'ids' seja um array de inteiros existentes em contacts
        $validated = $request->validate([
            'ids'   => ['required', 'array'],
            'ids.*' => ['integer', 'exists:contacts,id'],
        ]);

        $ids = $validated['ids'];

        // 2) Buscar os contatos correspondentes
        $contacts = Contact::whereIn('id', $ids)->get();

        // 3) Definir os cabeçalhos do CSV
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

        // 4) Gerar o nome do arquivo
        $filename = 'contacts_export_' . now()->format('Ymd_His') . '.csv';

        // 5) Retornar um StreamedResponse via streamDownload
        return Response::streamDownload(function () use ($contacts, $columns) {
            $handle = fopen('php://output', 'w');

            // Escreve o cabeçalho
            fputcsv($handle, $columns);

            // Escreve cada linha do CSV
            foreach ($contacts as $c) {
                fputcsv($handle, [
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

            fclose($handle);
        }, $filename, [
            'Content-Type'        => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
