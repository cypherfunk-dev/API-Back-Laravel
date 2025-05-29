<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inventory>
 */
class InventoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            'item_id' => \App\Models\Item::factory(),
            'color_id' => \App\Models\Color::factory(),
            'size_id' => \App\Models\Size::factory(),
            'price' => $this->faker->randomFloat(2, 5000, 30000),
        ];
    }
}
