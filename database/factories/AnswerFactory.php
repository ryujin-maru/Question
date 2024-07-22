<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Question;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'question_id' => Question::factory(),
            'answer_1' => $this->faker->realText(10),
            'answer_2' => $this->faker->realText(10),
            'answer_3' => $this->faker->realText(10),
            'correct' => 'answer_1'
        ];
    }
}
