<?php

namespace App\Repositories;

use App\Models\Contact;

class EloquentContactRepository implements ContactRepositoryInterface
{
    protected Contact $model;

    public function __construct(Contact $model)
    {
        $this->model = $model;
    }

    public function all()
    {
        return $this->model->all();
    }

    public function find(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(int $id, array $data)
    {
        $contact = $this->find($id);
        $contact->update($data);
        return $contact;
    }

    public function delete(int $id): bool
    {
        return $this->find($id)->delete();
    }
}
