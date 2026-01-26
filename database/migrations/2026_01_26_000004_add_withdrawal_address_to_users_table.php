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
            if (!Schema::hasColumn('users', 'withdrawal_address')) {
                $table->string('withdrawal_address')->nullable()->after('withdrawal_pin');
            }
            if (!Schema::hasColumn('users', 'withdrawal_currency')) {
                $table->string('withdrawal_currency', 32)->nullable()->after('withdrawal_address');
            }
            if (!Schema::hasColumn('users', 'withdrawal_network')) {
                $table->string('withdrawal_network', 32)->nullable()->after('withdrawal_currency');
            }
            if (!Schema::hasColumn('users', 'withdrawal_address_bound_at')) {
                $table->timestamp('withdrawal_address_bound_at')->nullable()->after('withdrawal_network');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columns = ['withdrawal_address', 'withdrawal_currency', 'withdrawal_network', 'withdrawal_address_bound_at'];
            foreach ($columns as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
