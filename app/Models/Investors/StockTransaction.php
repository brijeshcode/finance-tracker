<?php

namespace App\Models\Investors;

use App\Models\Admin\Platform;
use App\Models\Admin\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransaction extends Model
{
    
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['date', 'user_id', 'stock_id', 'platform_id', 'exchange', 'quantity',
            'rate', 'price', 'is_buy', 'transaciton_charge', 'note' ];

    protected $casts = [
        'active' => 'boolean',
        'is_buy' => 'boolean',
    ];
    
    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function platoform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    public function scopeDate(Builder $query, string $date): void
    {
        $query->where('date', $date);
    }
 
    public function scopeUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    public function scopeIsNote(Builder $query, string $note): void
    {
        $query->where('note', $note);
    }

    public function scopeIsPlatform(Builder $query, string $platformId): void
    {
        $query->where('platform_id', $platformId);
    }
}
