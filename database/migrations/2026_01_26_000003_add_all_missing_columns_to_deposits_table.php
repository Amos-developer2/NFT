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
            if (!Schema::hasColumn('deposits', 'network')) {
                $table->string('network', 32)->nullable()->after('currency');
            }
            if (!Schema::hasColumn('deposits', 'pay_currency')) {
                $table->string('pay_currency', 32)->nullable()->after('pay_id');
            }
            if (!Schema::hasColumn('deposits', 'pay_amount')) {
                $table->decimal('pay_amount', 18, 8)->nullable()->after('pay_currency');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('deposits', function (Blueprint $table) {
            $columns = ['currency', 'network', 'pay_currency', 'pay_amount'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('deposits', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
