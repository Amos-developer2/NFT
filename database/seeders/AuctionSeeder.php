<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Auction;
use App\Models\Nft;
use Carbon\Carbon;

class AuctionSeeder extends Seeder
{
    public function run()
    {
        $nfts = Nft::all();
        foreach ($nfts as $i => $nft) {
            $status = ['Live', 'Upcoming', 'Ended'][array_rand(['Live', 'Upcoming', 'Ended'])];
            $start = rand(20, 100);
            $bid = $start + rand(1, 50);
            Auction::create([
                'nft_id' => $nft->id,
                'starting_price' => $start,
                'highest_bid' => $status === 'Ended' ? $bid : ($status === 'Live' ? $bid : $start),
                'status' => $status,
                'end_time' => $status === 'Live'
                    ? now()->addMinutes(rand(5, 120))
                    : ($status === 'Upcoming'
                        ? now()->addDays(rand(1, 3))
                        : now()->subMinutes(rand(1, 60))),
            ]);
        }
    }
}
