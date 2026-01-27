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
        Schema::create('receipts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('nft_id');
            $table->decimal('amount', 12, 2)->comment('Purchase price in USDT');
            $table->string('receipt_number')->unique()->comment('Unique receipt ID');
            $table->string('status')->default('completed')->comment('completed, pending, failed');
            $table->string('payment_method')->default('USDT Balance')->comment('How payment was made');
            $table->text('transaction_details')->nullable()->comment('JSON transaction info');
            $table->string('email_status')->default('pending')->comment('pending, sent, failed');
            $table->timestamp('email_sent_at')->nullable();
            $table->timestamps();
            
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('nft_id')->references('id')->on('nfts')->onDelete('cascade');
            $table->index('user_id');
            $table->index('nft_id');
            $table->index('receipt_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('receipts');
    }
};
