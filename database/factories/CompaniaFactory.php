<?php

namespace Database\Factories;

use App\Models\Compania;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompaniaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Compania::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
        ];
    }

    public function run()
    {
        Compania::factory()->count(3)->create();
    }
}
