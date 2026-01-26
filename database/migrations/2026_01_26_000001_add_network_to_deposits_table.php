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
        Schema::table('deposits', function (Blueprint $table) {
            if (!Schema::hasColumn('deposits', 'currency')) {
                $table->string('currency', 32)->nullable()->after('amount');
            }
        });
        
        Schema::table('deposits', function (Blueprint $table) {
            if (!Schema::hasColumn('deposits', 'network')) {
                $table->string('network', 32)->nullable()->after('currency');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn(['network', 'currency']);
        });
    }
};
