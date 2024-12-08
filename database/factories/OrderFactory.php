<?php

namespace Database\Factories;

use App\Models\SgoOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = SgoOrder::class;
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'last_name' => $this->faker->lastName(),
            'address' => $this->faker->address(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'total_price' => $this->faker->numberBetween(10000, 1000000), // Giá trị từ 10,000 đến 1,000,000 VND
            'status' => $this->faker->randomElement(['pending', 'cancelled', 'completed']),
        ];
    }
}
