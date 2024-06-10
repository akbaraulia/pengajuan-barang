<?php

namespace Database\Factories;

use App\Models\Pengajuan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PengajuanFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Pengajuan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $quantity = $this->faker->randomDigitNotNull;
        $price = $this->faker->randomNumber(2);

        return [
            'user_id' => User::factory(),
            'item_name' => $this->faker->word,
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $quantity * $price,
            'status' => $this->faker->randomElement(['pending', 'approved_manager', 'approved_finance', 'rejected']),
            'rejection_reason' => $this->faker->sentence,
            'proof_of_transfer' => $this->faker->imageUrl(),
        ];
    }
}