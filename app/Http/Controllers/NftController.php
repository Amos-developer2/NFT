<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nft;
use App\Models\Receipt;
use App\Mail\PurchaseReceiptMail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

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

        // Increment view count
        $nft->incrementViews();

        // Check if current user has liked this NFT
        $isLiked = $nft->isLikedByUser();

        return view('nft.purchase', compact('nft', 'isLiked'));
    }

    /**
     * Toggle like/unlike for an NFT
     */
    public function toggleLike(Request $request, $id)
    {
        $nft = Nft::find($id);
        if (!$nft) {
            return response()->json(['error' => 'NFT not found'], 404);
        }

        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'Please login to like NFTs'], 401);
        }

        $isLiked = $nft->toggleLike($user->id);

        return response()->json([
            'success' => true,
            'liked' => $isLiked,
            'likes_count' => $nft->fresh()->likes_count,
        ]);
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
        
        // Admin IDs whose NFTs are available for purchase
        $adminIds = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        
        // Check if NFT is available for purchase (owned by admin) or already owned by a regular user
        if ($nft->user_id && !in_array($nft->user_id, $adminIds)) {
            return redirect()->route('nft.purchase', ['id' => $id])->with('error', 'NFT already owned by another user');
        }
        
        // Check if user already owns this NFT
        $user = Auth::user();
        if ($nft->user_id === $user->id) {
            return redirect()->route('nft.purchase', ['id' => $id])->with('error', 'You already own this NFT');
        }
        
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
        
        // Create receipt record
        $receiptNumber = 'RCP-' . now()->format('YmdHis') . '-' . Str::random(6);
        $receipt = Receipt::create([
            'user_id' => $user->id,
            'nft_id' => $nft->id,
            'amount' => $price,
            'receipt_number' => $receiptNumber,
            'status' => 'completed',
            'payment_method' => 'USDT Balance',
            'transaction_details' => [
                'nft_id' => $nft->id,
                'nft_name' => $nft->name,
                'previous_owner' => $nft->user_id,
                'payment_currency' => 'USDT',
                'ip_address' => $request->ip(),
            ],
            'email_status' => 'pending',
        ]);
        
        // Send receipt email asynchronously
        try {
            Mail::to($user->email)->send(new PurchaseReceiptMail($receipt));
            $receipt->update([
                'email_status' => 'sent',
                'email_sent_at' => now(),
            ]);
        } catch (\Exception $e) {
            // Log email error but don't fail the purchase
            $receipt->update(['email_status' => 'failed']);
            \Log::error('Failed to send receipt email: ' . $e->getMessage());
        }
        
        return redirect()->route('collection')->with('success', "Successfully purchased {$nft->name}! Receipt sent to {$user->email}");
    }

    /**
     * Show the NFT detail page
     */
    public function show($id)
    {
        $nft = Nft::with('owner')->find($id);
        if (!$nft) {
            return redirect()->route('collection')->with('error', 'NFT not found');
        }

        // Example statistics logic (replace with real queries)
        $statistics = [
            'highest' => $nft->price_history()->max('price') ?? $nft->purchase_price,
            'lowest' => $nft->price_history()->min('price') ?? $nft->purchase_price,
            'change_percent' => $nft->getPriceChangePercent(),
        ];

        // Get bids for this NFT
        $bids = $nft->bids()->with('user')->get();

        return view('nft.show', compact('nft', 'statistics', 'bids'));
    }

    /**
     * Sell NFT (stub)
     */
    public function sell(Request $request, $id)
    {
        $nft = Nft::find($id);
        $user = Auth::user();
        if (!$nft || $nft->owner_id !== $user->id) {
            return redirect()->route('nft.show', $id)->with('error', 'You do not own this NFT.');
        }
        // TODO: Implement selling logic (e.g., list for sale, auction, etc.)
        return redirect()->route('nft.show', $id)->with('success', 'NFT listed for sale.');
    }
}
