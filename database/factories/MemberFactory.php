<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'user_id'       => User::factory(), // ← Auto User create
            'membership_no' => 'MBR' . str_pad(
                                   fake()->unique()->numberBetween(1, 999),
                                   3, '0', STR_PAD_LEFT
                               ),
        ];
    }
}