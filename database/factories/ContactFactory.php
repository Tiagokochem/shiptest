<?php

namespace Database\Factories;

use App\Models\Contact;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $model = Contact::class;

    public function definition()
    {
        return [
            'cep'             => $this->faker->numerify('########'),
            'estado'          => $this->faker->stateAbbr(),
            'cidade'          => $this->faker->city(),
            'bairro'          => $this->faker->word(),
            'endereco'        => $this->faker->streetName(),
            'numero'          => $this->faker->buildingNumber(),
            'nome_contato'    => $this->faker->name(),
            'email_contato'   => $this->faker->unique()->safeEmail(),
            'telefone_contato'=> $this->faker->phoneNumber(),
        ];
    }
}
