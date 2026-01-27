<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Auth;

class Nft extends Model
{
    protected $fillable = [
        'name',
        'image',
        'background',
        'value',
        'rarity',
        'user_id',
        'price',
        'purchase_price',
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
    ];

    protected $casts = [
        'property_rarities' => 'array',
        'creator_royalty' => 'decimal:2',
        'value' => 'decimal:2',
        'price' => 'decimal:2',
        'purchase_price' => 'decimal:2',
    ];

    /**
     * Get auctions for this NFT.
     */
    public function auctions(): HasMany
    {
        return $this->hasMany(Auction::class);
    }

    /**
     * Get the owner of the NFT.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all likes for this NFT.
     */
    public function likes(): HasMany
    {
        return $this->hasMany(NftLike::class);
    }

    /**
     * Get the price history for this NFT.
     */
    public function price_history(): HasMany
    {
        return $this->hasMany(NftPriceHistory::class);
    }

    /**
     * Check if the current user has liked this NFT.
     */
    public function isLikedByUser(?int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) {
            return false;
        }
        return $this->likes()->where('user_id', $userId)->exists();
    }

    /**
     * Increment the view count for this NFT.
     */
    public function incrementViews(): void
    {
        $this->increment('views');
    }

    /**
     * Toggle like for the current user.
     */
    public function toggleLike(?int $userId = null): bool
    {
        $userId = $userId ?? Auth::id();
        if (!$userId) {
            return false;
        }

        $existingLike = $this->likes()->where('user_id', $userId)->first();

        if ($existingLike) {
            $existingLike->delete();
            $this->decrement('likes_count');
            return false; // Unliked
        } else {
            $this->likes()->create(['user_id' => $userId]);
            $this->increment('likes_count');
            return true; // Liked
        }
    }

    /**
     * Get the shortened contract address for display.
     */
    public function getShortContractAddressAttribute(): string
    {
        if (!$this->contract_address) {
            return 'N/A';
        }
        return substr($this->contract_address, 0, 6) . '...' . substr($this->contract_address, -4);
    }

    /**
     * Get rarity percentage for a specific property.
     */
    public function getPropertyRarity(string $property): float
    {
        $rarities = $this->property_rarities ?? [];
        return $rarities[$property] ?? $this->getDefaultRarity($property);
    }

    /**
     * Get default rarity based on property type.
     */
    private function getDefaultRarity(string $property): float
    {
        $defaults = [
            'background' => 15.0,
            'rarity' => 5.0,
            'type' => 25.0,
            'style' => 20.0,
            'tier' => 10.0,
        ];
        return $defaults[$property] ?? 10.0;
    }

    /**
     * Generate a contract address if not set.
     */
    public static function generateContractAddress(): string
    {
        return '0x' . bin2hex(random_bytes(20));
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($nft) {
            // Auto-generate contract address if not set
            if (empty($nft->contract_address)) {
                $nft->contract_address = self::generateContractAddress();
            }
            // Auto-generate edition number if not set
            if (empty($nft->edition)) {
                $nft->edition = self::max('edition') + 1;
            }
        });
    }
}
