<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Article::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'author_id' => User::factory()->create()->id,
            'title' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(7),
            'content_raw' => $this->faker->sentence(5),
            'content' => $this->faker->text(),
        ];
    }
}
