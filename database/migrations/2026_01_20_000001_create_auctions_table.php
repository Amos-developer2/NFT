<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nft_id');
            $table->decimal('starting_price', 16, 2);
            $table->decimal('highest_bid', 16, 2)->default(0);
            $table->string('status')->default('Upcoming');
            $table->timestamp('end_time')->nullable();
            $table->timestamps();
            $table->foreign('nft_id')->references('id')->on('nfts')->onDelete('cascade');
        });
    }
    public function down()
    {
        Schema::dropIfExists('auctions');
    }
};
