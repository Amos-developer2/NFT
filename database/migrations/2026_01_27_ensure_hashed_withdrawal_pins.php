<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration {
    public function up()
    {
        // Get all users with a non-null withdrawal_pin
        $users = DB::table('users')->whereNotNull('withdrawal_pin')->get();
        foreach ($users as $user) {
            $pin = $user->withdrawal_pin;
            // Only hash if not already a bcrypt hash (starts with $2y$ or $2b$)
            if ($pin && !preg_match('/^\$2[aby]\$/', $pin)) {
                DB::table('users')->where('id', $user->id)
                    ->update(['withdrawal_pin' => Hash::make($pin)]);
            }
        }
    }

    public function down()
    {
        // Not reversible
    }
};
