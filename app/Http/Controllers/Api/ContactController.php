<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ContactServiceInterface;
use Illuminate\Http\Request;
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
     * Retorna a lista de todos os contatos.
     */
    public function index(): JsonResponse
    {
        $contacts = $this->service->list();
        return response()->json($contacts);
    }

    /**
     * POST /api/contacts
     * Cria um novo contato.
     */
    public function store(Request $request): JsonResponse
    {
        // Aqui você poderia validar $request->validate([...])
        $contact = $this->service->create($request->all());
        return response()->json($contact, 201);
    }

    /**
     * GET /api/contacts/{id}
     * Retorna um contato específico.
     */
    public function show(int $id): JsonResponse
    {
        $contact = $this->service->get($id);
        return response()->json($contact);
    }

    /**
     * PUT/PATCH /api/contacts/{id}
     * Atualiza um contato existente.
     */
    public function update(Request $request, int $id): JsonResponse
    {
        // $request->validate([...]);
        $updated = $this->service->update($id, $request->all());
        return response()->json($updated);
    }

    /**
     * DELETE /api/contacts/{id}
     * Exclui um contato.
     */
    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);
        return response()->json(null, 204);
    }
}
