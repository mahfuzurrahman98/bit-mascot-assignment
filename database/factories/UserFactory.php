<?php

namespace Database\Factories;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory {
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        // make an email from the first and last name
        $email = strtolower($firstName) . '.' . strtolower($lastName) . '@gmail.com';

        // take a phone from the faker, and replace anything in that rather than numbers with blank
        $phone = preg_replace('/[^0-9]/', '', $this->faker->phoneNumber());

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => $phone,
            'password' => static::$password ??= Hash::make('password'),
            'address' => $this->faker->address(),
            'dob' => $this->faker->date(),
            // same file for everyone
            'id_verification_file' => 'sample_file.pdf',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
