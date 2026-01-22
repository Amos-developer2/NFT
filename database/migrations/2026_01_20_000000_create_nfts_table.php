<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('nfts', function (Blueprint $table) {
            $table->id(); // unsignedBigInteger by default
            $table->string('name');
            $table->string('image')->nullable();
            $table->string('background')->nullable();
            $table->decimal('value', 16, 2)->default(0);
            $table->string('rarity')->nullable();
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('nfts');
    }
};
