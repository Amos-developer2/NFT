<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'account_id',
        'referral_code',
        'referred_by',
        'referral_count',
        'role',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function nfts()
    {
        return $this->hasMany(Nft::class);
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($user) {
            if (empty($user->account_id)) {
                $user->account_id = self::generateAccountId();
            }
            if (empty($user->referral_code)) {
                $user->referral_code = self::generateReferralCode();
            }
        });
    }

    /**
     * Generate a unique account ID.
     */
    public static function generateAccountId(): string
    {
        do {
            $accountId = str_pad(random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        } while (self::where('account_id', $accountId)->exists());

        return $accountId;
    }

    /**
     * Generate a unique referral code (8 digits).
     */
    public static function generateReferralCode(): string
    {
        do {
            $code = str_pad(random_int(10000000, 99999999), 8, '0', STR_PAD_LEFT);
        } while (self::where('referral_code', $code)->exists());

        return $code;
    }

    /**
     * Find user by referral code.
     */
    public static function findByReferralCode(string $code): ?self
    {
        return self::where('referral_code', $code)->first();
    }

    /**
     * Get the user who referred this user.
     */
    public function referrer()
    {
        return $this->belongsTo(User::class, 'referred_by');
    }

    /**
     * Get users referred by this user.
     */
    public function referrals()
    {
        return $this->hasMany(User::class, 'referred_by');
    }

    /**
     * Get referral link.
     */
    public function getReferralLinkAttribute(): string
    {
        return url('/register?ref=' . $this->referral_code);
    }

    /**
     * Check if user is active (has logged in within last 30 days).
     */
    public function isActive(): bool
    {
        // User is active if balance >= 20
        return ($this->balance ?? 0) >= 20;
    }

    /**
     * Get level 2 referrals (users referred by level 1 users).
     */
    public function getLevel2Referrals()
    {
        $level1Ids = $this->referrals()->pluck('id');
        return User::whereIn('referred_by', $level1Ids)->get();
    }

    /**
     * Get referrals at a specific level.
     * Level 1 = direct referrals
     * Level 2-6 = referrals of referrals
     */
    public function getReferralsAtLevel(int $level)
    {
        if ($level < 1 || $level > 6) {
            return collect();
        }

        if ($level === 1) {
            return $this->referrals()->get();
        }

        // Get IDs from previous level
        $previousLevelIds = collect([$this->id]);

        for ($i = 1; $i < $level; $i++) {
            $previousLevelIds = User::whereIn('referred_by', $previousLevelIds)->pluck('id');
            if ($previousLevelIds->isEmpty()) {
                return collect();
            }
        }

        return User::whereIn('referred_by', $previousLevelIds)->get();
    }

    /**
     * Get stats for referrals at a specific level.
     */
    public function getLevelStats(int $level): array
    {
        $users = $this->getReferralsAtLevel($level);

        return [
            'users' => $users,
            'total' => $users->count(),
            'active' => $users->filter(fn($u) => $u->isActive())->count(),
            'deposits' => $users->sum('total_deposits') ?? 0,
            'commission' => $this->getCommissionForLevel($level, $users),
        ];
    }

    /**
     * Get commission earned from a level.
     * Commission rates: L1=10%, L2=5%, L3=3%, L4=2%, L5=1%, L6=0.5%
     */
    public function getCommissionForLevel(int $level, $users = null): float
    {
        $rates = [1 => 0.10, 2 => 0.05, 3 => 0.03, 4 => 0.02, 5 => 0.01, 6 => 0.005];

        if (!isset($rates[$level])) {
            return 0;
        }

        $users = $users ?? $this->getReferralsAtLevel($level);
        $totalDeposits = $users->sum('total_deposits') ?? 0;

        return $totalDeposits * $rates[$level];
    }
}
