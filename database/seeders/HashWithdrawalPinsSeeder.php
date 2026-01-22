<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class HashWithdrawalPinsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereNotNull('withdrawal_pin')->get();
        foreach ($users as $user) {
            $pin = $user->withdrawal_pin;
            // Only hash if not already hashed (bcrypt hashes start with $2y$ or $2b$)
            if (!str_starts_with($pin, '$2y$') && !str_starts_with($pin, '$2b$')) {
                $user->withdrawal_pin = Hash::make($pin);
                $user->save();
            }
        }
    }
}
