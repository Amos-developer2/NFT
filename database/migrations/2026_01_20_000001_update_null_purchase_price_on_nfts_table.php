<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

class UpdateNullPurchasePriceOnNftsTable extends Migration
{
    /**
     * Run the migrations.
     * @return void
     */
    public function up()
    {
        DB::table('nfts')->whereNull('purchase_price')->update(['purchase_price' => 20]);
    }

    /**
     * Reverse the migrations.
     * @return void
     */
    public function down()
    {
        // Optionally set back to NULL if needed
        // DB::table('nfts')->where('purchase_price', 20)->update(['purchase_price' => null]);
    }
}
