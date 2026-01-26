<?php
// tests/Feature/AdminAuctionEndTest.php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Nft;
use App\Models\Auction;
use App\Models\Bid;

class AdminAuctionEndTest extends TestCase
{
    use RefreshDatabase;

    public function test_seller_is_credited_when_auction_is_ended()
    {
        $seller = User::factory()->create(['balance' => 0]);
        $bidder = User::factory()->create();
        $nft = Nft::factory()->create(['user_id' => $seller->id]);
        $auction = Auction::create([
            'nft_id' => $nft->id,
            'user_id' => $seller->id,
            'starting_price' => 10,
            'highest_bid' => 50,
            'status' => 'active',
            'end_time' => now()->addHour(),
        ]);
        Bid::create([
            'auction_id' => $auction->id,
            'user_id' => $bidder->id,
            'amount' => 50,
        ]);

        $this->actingAs(User::factory()->admin()->create());
        $response = $this->post(route('admin.auctions.end', $auction));
        $response->assertRedirect();
        $auction->refresh();
        $seller->refresh();
        $this->assertEquals('ended', $auction->status);
        $this->assertEquals(50, $seller->balance);
        // Try ending again, balance should not increase
        $this->post(route('admin.auctions.end', $auction));
        $seller->refresh();
        $this->assertEquals(50, $seller->balance);
    }

    public function test_no_credit_if_no_bids()
    {
        $seller = User::factory()->create(['balance' => 0]);
        $nft = Nft::factory()->create(['user_id' => $seller->id]);
        $auction = Auction::create([
            'nft_id' => $nft->id,
            'user_id' => $seller->id,
            'starting_price' => 10,
            'highest_bid' => 10,
            'status' => 'active',
            'end_time' => now()->addHour(),
        ]);
        $this->actingAs(User::factory()->admin()->create());
        $this->post(route('admin.auctions.end', $auction));
        $auction->refresh();
        $seller->refresh();
        $this->assertEquals('ended', $auction->status);
        $this->assertEquals(0, $seller->balance);
    }
}
