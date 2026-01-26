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
        // Only add the column if it does not exist
        if (!\Schema::hasColumn('deposits', 'network')) {
            Schema::table('deposits', function (Blueprint $table) {
                $table->string('network')->nullable()->after('currency');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Only drop the column if it exists
        if (\Schema::hasColumn('deposits', 'network')) {
            Schema::table('deposits', function (Blueprint $table) {
                $table->dropColumn('network');
            });
        }
    }
};
