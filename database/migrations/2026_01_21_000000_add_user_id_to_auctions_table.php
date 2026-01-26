<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Ensure user_id is nullable before updating invalid values
        \DB::statement('ALTER TABLE auctions MODIFY user_id BIGINT UNSIGNED NULL');
        // Set invalid user_id values to null before adding the foreign key
        \DB::statement('UPDATE auctions SET user_id = NULL WHERE user_id IS NOT NULL AND user_id NOT IN (SELECT id FROM users)');
        Schema::table('auctions', function (Blueprint $table) {
            if (!\Schema::hasColumn('auctions', 'user_id')) {
                $table->unsignedBigInteger('user_id')->nullable()->after('nft_id');
            }
            try {
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            } catch (\Throwable $e) {
                // Foreign key may already exist, ignore
            }
        });
    }
    public function down()
    {
        Schema::table('auctions', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};
