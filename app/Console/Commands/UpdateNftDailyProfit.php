<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Nft;

class UpdateNftDailyProfit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'nft:update-daily-profit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update each NFT price so daily profit ranges from 0.1% to 0.5%';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Nft::all()->each(function ($nft) {
            if ($nft->purchase_price > 0) {
                $percent = rand(10, 50) / 100; // 0.1% to 0.5%
                $newPrice = $nft->purchase_price * (1 + $percent / 100);
                $nft->price = round($newPrice, 2);
                $nft->save();
            }
        });
        $this->info('NFT prices updated for daily profit.');
    }
}
