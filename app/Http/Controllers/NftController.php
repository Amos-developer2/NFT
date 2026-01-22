<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nft;
use Illuminate\Support\Facades\Auth;

class NftController extends Controller
{
    /**
     * Get NFT data by ID
     */
    private function getNftById($id)
    {
        // NFT catalog - in production, this would come from database
        $nfts = [
            1001 => [
                'id' => 1001,
                'name' => 'Eternal Rose',
                'price' => 2.80,
                'value' => 3.10,
                'image' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" font-size="80">🌹</text></svg>',
                'background' => 'linear-gradient(135deg, #a7f3d0 0%, #34d399 100%)',
                'backdrop_pattern' => 'money',
                'rarity' => 'Rare',
                'model' => 'Eternal Rose',
                'symbol' => 'Money',
                'backdrop' => 'Hunter Green',
                'supply' => '312K',
                'floor_price' => 3.35,
            ],
            1002 => [
                'id' => 1002,
                'name' => 'Plush Pepe',
                'price' => 4.00,
                'value' => 4.50,
                'image' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" font-size="80">🐸</text></svg>',
                'background' => 'linear-gradient(135deg, #a7f3d0 0%, #34d399 100%)',
                'backdrop_pattern' => 'stars',
                'rarity' => 'Epic',
                'model' => 'Plush Pepe',
                'symbol' => 'Stars',
                'backdrop' => 'Forest Green',
                'supply' => '156K',
                'floor_price' => 4.50,
            ],
            1003 => [
                'id' => 1003,
                'name' => 'Golden Star',
                'price' => 2.50,
                'value' => 2.85,
                'image' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" font-size="80">⭐</text></svg>',
                'background' => 'linear-gradient(135deg, #fde68a 0%, #fbbf24 100%)',
                'backdrop_pattern' => 'sparkles',
                'rarity' => 'Common',
                'model' => 'Golden Star',
                'symbol' => 'Sparkles',
                'backdrop' => 'Sunny Yellow',
                'supply' => '500K',
                'floor_price' => 2.85,
            ],
            1004 => [
                'id' => 1004,
                'name' => 'Cyber Cat',
                'price' => 5.00,
                'value' => 5.80,
                'image' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" font-size="80">🐱</text></svg>',
                'background' => 'linear-gradient(135deg, #c4b5fd 0%, #8b5cf6 100%)',
                'backdrop_pattern' => 'cyber',
                'rarity' => 'Legendary',
                'model' => 'Cyber Cat',
                'symbol' => 'Neon',
                'backdrop' => 'Purple Haze',
                'supply' => '50K',
                'floor_price' => 5.80,
            ],
            1005 => [
                'id' => 1005,
                'name' => 'Blue Diamond',
                'price' => 1.80,
                'value' => 2.10,
                'image' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" font-size="80">💎</text></svg>',
                'background' => 'linear-gradient(135deg, #bfdbfe 0%, #60a5fa 100%)',
                'backdrop_pattern' => 'gems',
                'rarity' => 'Common',
                'model' => 'Blue Diamond',
                'symbol' => 'Gems',
                'backdrop' => 'Ocean Blue',
                'supply' => '800K',
                'floor_price' => 2.10,
            ],
            1006 => [
                'id' => 1006,
                'name' => 'Fire Dragon',
                'price' => 6.50,
                'value' => 7.20,
                'image' => 'data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><text y=".9em" font-size="80">🐉</text></svg>',
                'background' => 'linear-gradient(135deg, #fecaca 0%, #f87171 100%)',
                'backdrop_pattern' => 'flames',
                'rarity' => 'Legendary',
                'model' => 'Fire Dragon',
                'symbol' => 'Flames',
                'backdrop' => 'Crimson Red',
                'supply' => '25K',
                'floor_price' => 7.20,
            ],
        ];

        return $nfts[$id] ?? null;
    }

    /**
     * Show the purchase confirmation page
     */
    public function showPurchase($id)
    {
        $nft = Nft::find($id);
        if (!$nft) {
            return redirect()->route('home')->with('error', 'NFT not found');
        }
        return view('nft.purchase', compact('nft'));
    }

    /**
     * Process the NFT purchase
     */
    public function buy(Request $request, $id)
    {
        $nft = Nft::find($id);
        if (!$nft) {
            return redirect()->route('nft.purchase', ['id' => $id])->with('error', 'NFT not found');
        }
        // Check if already owned
        if ($nft->user_id) {
            return redirect()->route('home')->with('error', 'NFT already owned');
        }
        $user = Auth::user();
        $price = $nft->price ?? 0; // USDT
        if ($user->balance < $price) {
            return redirect()->route('nft.purchase', ['id' => $id])->with('error', 'Insufficient USDT balance to purchase this NFT.');
        }
        // Deduct price from user balance
        $user->balance -= $price;
        $user->save();
        // Assign NFT to user and save purchase price
        $nft->user_id = $user->id;
        $nft->purchase_price = $price;
        $nft->save();
        // TODO: Record transaction if needed
        return redirect()->route('collection')->with('success', "Successfully purchased {$nft->name}!");
    }
}
