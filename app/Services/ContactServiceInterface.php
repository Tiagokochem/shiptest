<?php

namespace App\Services;

interface ContactServiceInterface
{
    /**
     * Retorna todos os contatos.
     *
     * @return mixed
     */
    public function list(): mixed;

    /**
     * Retorna um contato pelo ID.
     *
     * @param int $id
     * @return mixed
     */
    public function get(int $id): mixed;

    /**
     * Cria um novo contato.
     *
     * @param array $data
     * @return mixed
     */
    public function create(array $data): mixed;

    /**
     * Atualiza um contato existente.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data): mixed;

    /**
     * Remove um contato.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;
}
