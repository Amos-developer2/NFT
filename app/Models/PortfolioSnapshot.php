<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PortfolioSnapshot extends Model
{
    protected $fillable = [
        'user_id',
        'value',
    ];
}
