<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Bid;
use App\Models\Auction;
use App\Models\User;

class BidSeeder extends Seeder
{
    public function run()
    {
        $user = User::first();
        $auctions = Auction::where('status', 'Live')->get();
        foreach ($auctions as $auction) {
            $bidCount = rand(2, 8);
            $amount = $auction->starting_price;
            for ($i = 0; $i < $bidCount; $i++) {
                $amount += rand(1, 10);
                Bid::create([
                    'auction_id' => $auction->id,
                    'user_id' => $user->id,
                    'amount' => $amount,
                ]);
            }
        }
    }
}
