<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class VerificationCode extends Model
{
    protected $fillable = [
        'email',
        'code',
        'type',
        'is_used',
        'expires_at',
    ];

    protected $casts = [
        'is_used' => 'boolean',
        'expires_at' => 'datetime',
    ];

    /**
     * Generate a new verification code for an email
     */
    public static function generateCode(string $email, string $type = 'registration'): self
    {
        // Invalidate any existing codes for this email and type
        self::where('email', $email)
            ->where('type', $type)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Generate a 6-digit code
        $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);

        return self::create([
            'email' => $email,
            'code' => $code,
            'type' => $type,
            'expires_at' => now()->addMinutes(10),
        ]);
    }

    /**
     * Verify a code
     */
    public static function verifyCode(string $email, string $code, string $type = 'registration'): bool
    {
        $verification = self::where('email', $email)
            ->where('code', $code)
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->first();

        if ($verification) {
            $verification->update(['is_used' => true]);
            return true;
        }

        return false;
    }

    /**
     * Check if a valid code exists for email
     */
    public static function hasValidCode(string $email, string $type = 'registration'): bool
    {
        return self::where('email', $email)
            ->where('type', $type)
            ->where('is_used', false)
            ->where('expires_at', '>', now())
            ->exists();
    }
}
