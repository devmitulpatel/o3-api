<?php

namespace Database\Factories;

use App\Models\Media;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class MediaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Media::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $extension = $this->faker->fileExtension;
        $name = $this->faker->md5 . '.' . $extension;

        return [
            'id'            => uuid(),
            'user_id'       => User::factory(),
            'name'          => $name,
            'extension'     => $extension,
            'path'          => 'uploads/' . $name,
            'tag'           => $this->faker->word,
            'mediable_type' => null,
            'mediable_id'   => null,
        ];
    }
}
