<?php

namespace App\Services;

use App\Repositories\ContactRepositoryInterface;

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
    public function create(array $data): mixed
    {
        return $this->repository->create($data);
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
