<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Size>
 */
class SizeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $sizes = [['S', 'Small'], ['M', 'Medium'], ['L', 'Large']];
        [$code, $name] = $this->faker->randomElement($sizes);
        return compact('name', 'code');
    }

    /**
     * Indicate that the size is 'Small'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function small(): static {
        return $this->state(fn () => ['name' => 'Small', 'code' => 'S']);
    }

    /**
     * Indicate that the size is 'Medium'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function medium(): static {
        return $this->state(fn () => ['name' => 'Medium', 'code' => 'M']);
    }

    /**
     * Indicate that the size is 'Large'.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function large(): static {
        return $this->state(fn () => ['name' => 'Large', 'code' => 'L']);
    }
}
