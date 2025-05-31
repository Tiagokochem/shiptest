<?php

namespace App\Services;

use App\Repositories\ContactRepositoryInterface;
use App\Jobs\SendContactCreatedEmail;
use App\Models\Contact;

class ContactService implements ContactServiceInterface
{
    protected ContactRepositoryInterface $repository;

    public function __construct(ContactRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Retorna todos os contatos.
     *
     * @return mixed
     */
    public function list(): mixed
    {
        return $this->repository->all();
    }

    /**
     * Retorna um contato pelo ID.
     *
     * @param int $id
     * @return mixed
     */
    public function get(int $id): mixed
    {
        return $this->repository->find($id);
    }

    /**
     * Cria um novo contato.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data)
    {
        // 1) Criar o contato via repositório
        /** @var Contact $contact */
        $contact = $this->repository->create($data);
    
        // 2) Despachar o job para a fila 'back_emails'
        SendContactCreatedEmail::dispatch($contact)->onQueue('back_emails');
    
        return $contact;
    }

    /**
     * Atualiza um contato existente.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed
    {
        return $this->repository->update($id, $data);
    }

    /**
     * Remove um contato.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }
}
