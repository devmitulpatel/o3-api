<?php

namespace Database\Factories;

use App\Models\Device;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeviceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Device::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'    => User::factory(),
            'token'      => $this->faker->md5,
            'type'       => $this->faker->randomElement(['Android', 'iOS']),
            'os_version' => (string) rand(1, 10),
            'name'       => $this->faker->name,
        ];
    }
}
