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
}
