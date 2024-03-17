<?php

namespace App\Models\Investors;

use App\Models\User;
use App\Models\Admin\Platform;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InvestorPlatform extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['user_id', 'platform_id', 'registration_date', 'active', 'note'];

    protected $casts = [
        'active' => 'boolean'
    ];

    public function investor() : BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function platform() : BelongsTo
    {
        return $this->belongsTo(Platform::class, 'platform_id');
    }

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeIsInvestor(Builder $query, String $userId): void
    {
        $query->where('user_id', $userId);
    }
}
