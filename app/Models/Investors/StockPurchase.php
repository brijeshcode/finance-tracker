<?php

namespace App\Models\Investors;

use App\Models\Admin\Platform;
use App\Models\Admin\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockPurchase extends Model
{
    use SoftDeletes;
    use HasFactory;

    
    protected $fillable = [
            'date', 'platform_id', 'user_id', 'stock_id', 'quantity', 'rate', 'price', 
            'transaction_fee', 'sale_id','sale_rate', 'partial_sale_quantity', 'profit_on_sale', 'age_days', 'note' 
        ];

    protected $casts = [
        'quantity' => 'integer',
        'partial_sale_quantity' => 'integer',
        'rate' => 'float',
        'price' => 'float',
        'sale_rate' => 'float',
        'profit_on_sale' => 'float',
        'transaction_fee' => 'float',

    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function platform(): BelongsTo
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

    public function scopeCurrentStock(Builder $query): void
    {
        $query->whereNull('sale_id');
    }

    public function scopeIsPartial(Builder $query): void
    {
        $query->where('partial_sale_quantity' , '>', 0);
    }

    public function scopeIncludePartial(Builder $query): void
    {
        $query->orWhere('partial_sale_quantity' , '>', 0);
    }

    public function scopeCurrentWithPartial(Builder $query): void
    {
        $query->whereNull('sale_id')->orWhere('partial_sale_quantity' , '>', 0);

    }

    public function scopeIsPlatform(Builder $query, int $platformId): void
    {
        $query->where('platform_id', $platformId);
    }

    public function scopeIsStock(Builder $query, int $stockId): void
    {
        $query->where('stock_id', $stockId);
    }

    public function scopeIsDate(Builder $query, int $date): void
    {
        $query->where('date', $date);
    }

    public function scopeIsNote(Builder $query, string $note): void
    {
        $query->where('note', $note);
    }
}
