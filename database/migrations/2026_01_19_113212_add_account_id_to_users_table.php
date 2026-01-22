<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('account_id', 10)->unique()->nullable()->after('id');
        });

        // Generate account_id for existing users
        $users = \App\Models\User::whereNull('account_id')->get();
        foreach ($users as $user) {
            $user->account_id = $this->generateAccountId();
            $user->save();
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('account_id');
        });
    }

    /**
     * Generate a unique account ID.
     */
    private function generateAccountId(): string
    {
        do {
            $accountId = str_pad(random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        } while (\App\Models\User::where('account_id', $accountId)->exists());

        return $accountId;
    }
};
