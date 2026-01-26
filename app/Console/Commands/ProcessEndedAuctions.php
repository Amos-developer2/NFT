<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Auction;
use App\Models\User;
use App\Models\Bid;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProcessEndedAuctions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auctions:process-ended';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process ended auctions, credit seller balances, and update auction status.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $endedAuctions = Auction::where('status', 'Live')
            ->where('end_time', '<', $now)
            ->get();

        foreach ($endedAuctions as $auction) {
            DB::transaction(function () use ($auction) {
                // Find the highest bid
                $highestBid = $auction->bids()->orderByDesc('amount')->first();
                $seller = $auction->user;

                if ($highestBid) {
                    // Credit seller with highest bid amount (profit + capital)
                    $seller->balance += $highestBid->amount;
                    $seller->save();
                }
                // Mark auction as ended
                $auction->status = 'Ended';
                $auction->save();
            });
        }

        $this->info("Processed {$endedAuctions->count()} ended auctions.");
    }
}
