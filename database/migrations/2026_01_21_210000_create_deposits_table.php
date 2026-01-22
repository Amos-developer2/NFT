<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepositsTable extends Migration {
    public function up(){
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->decimal('amount', 18, 8);
            $table->string('currency')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('pay_id')->nullable();
            $table->string('pay_currency')->nullable();
            $table->decimal('pay_amount', 18, 8)->nullable();
            $table->decimal('paid_amount', 18, 8)->nullable();
            $table->string('txid')->nullable();
            $table->string('tx_hash')->nullable();
            $table->string('pay_id')->nullable();
            $table->string('order_id')->nullable();
            $table->string('pay_address')->nullable();
            $table->string('status')->default('waiting');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('deposits', function (Blueprint $table) {
            $table->dropColumn([
                'currency',
                'payment_id',
                'pay_id',
                'pay_currency',
                'pay_amount',
                'paid_amount',
                'txid',
                'tx_hash',
            ]);
        });
    }
}
