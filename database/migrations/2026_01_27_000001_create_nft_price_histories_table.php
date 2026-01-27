<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nft_price_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nft_id')->constrained('nfts')->onDelete('cascade');
            $table->decimal('price', 16, 8);
            $table->timestamp('recorded_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nft_price_histories');
    }
};
