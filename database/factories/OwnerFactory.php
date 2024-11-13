<?php

namespace Database\Factories;

use App\Models\Owner;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Traits\myHelper;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Owner>
 */
class OwnerFactory extends Factory
{
    protected $model = Owner::class;
    use myHelper;

    public function definition(): array
    {
        return [
            'o_username' => substr($this->faker->unique()->userName, 0, 15),
            'o_pass' => Hash::make('o_pass'),
            'o_name'  => $this->faker->name,
            'o_sdt' => $this->vnPhone(),
            'o_dchi' => $this->faker->address,
            'o_nsinh' => $this->faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d')
        ];
    }

    

}
