<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    protected $fillable = [
        'user_id',
        'nft_id',
        'amount',
        'receipt_number',
        'status',
        'payment_method',
        'transaction_details',
        'email_status',
        'email_sent_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'transaction_details' => 'array',
        'email_sent_at' => 'datetime',
    ];

    /**
     * Get the user that owns this receipt
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the NFT that was purchased
     */
    public function nft()
    {
        return $this->belongsTo(Nft::class);
    }
}
