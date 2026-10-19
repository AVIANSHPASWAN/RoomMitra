<?php

namespace Database\Factories;

use App\Models\Room;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Room>
 */
class RoomFactory extends Factory
{
    protected $model = Room::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'location' => fake()->city(),
            'description' => fake()->paragraph(),
            'price' => fake()->numberBetween(7000, 25000),
            'beds' => fake()->numberBetween(1, 4),
            'available' => fake()->boolean(80),
        ];
    }
}
