<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        // Set user_id to 1 for auctions where user_id is NULL
        DB::table('auctions')->whereNull('user_id')->update(['user_id' => 1]);
    }

    public function down()
    {
        // Optionally revert user_id to NULL for those rows
        DB::table('auctions')->where('user_id', 1)->update(['user_id' => null]);
    }
};
