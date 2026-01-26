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
        Schema::table('nfts', function (Blueprint $table) {
            // Basic details
            $table->text('description')->nullable()->after('rarity');
            $table->string('creator')->nullable()->after('description');
            $table->string('collection')->nullable()->after('creator');
            
            // Stats
            $table->unsignedBigInteger('views')->default(0)->after('collection');
            $table->unsignedBigInteger('likes_count')->default(0)->after('views');
            $table->unsignedBigInteger('offers_count')->default(0)->after('likes_count');
            $table->unsignedBigInteger('trades_count')->default(0)->after('offers_count');
            
            // Properties
            $table->unsignedInteger('edition')->nullable()->after('trades_count');
            $table->string('type')->default('Art')->after('edition');
            $table->string('style')->default('2D')->after('type');
            $table->string('tier')->default('Standard')->after('style');
            
            // Blockchain details
            $table->string('contract_address')->nullable()->after('tier');
            $table->string('blockchain')->default('Ethereum')->after('contract_address');
            $table->string('token_standard')->default('ERC-721')->after('blockchain');
            $table->decimal('creator_royalty', 5, 2)->default(5.00)->after('token_standard');
            
            // Rarity percentages for properties (stored as JSON)
            $table->json('property_rarities')->nullable()->after('creator_royalty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('nfts', function (Blueprint $table) {
            $table->dropColumn([
                'description',
                'creator',
                'collection',
                'views',
                'likes_count',
                'offers_count',
                'trades_count',
                'edition',
                'type',
                'style',
                'tier',
                'contract_address',
                'blockchain',
                'token_standard',
                'creator_royalty',
                'property_rarities',
            ]);
        });
    }
};
