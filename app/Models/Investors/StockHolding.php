<?php

namespace App\Models\Investors;

use App\Models\Admin\Platform;
use App\Models\User;
use App\Models\Admin\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockHolding extends Model
{
    use SoftDeletes;
    use HasFactory;


    protected $fillable = ['date', 'stock_transaction_id', 'platform_id', 'user_id', 'stock_id', 'quantity',
            'rate', 'price', 'sold_quantity', 'long_termed', 'sold_out', 'is_reinvestment', 'reinvestment_lable', 'note' ];

    protected $casts = [
        'long_termed' => 'boolean',
        'sold_out' => 'boolean',
        'is_reinvestment' => 'boolean'
    ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }

    public function stock_transaction(): BelongsTo
    {
        return $this->belongsTo(StockTransaction::class);
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeDate(Builder $query, string $date): void
    {
        $query->where('date', $date);
    }
 
    public function scopeUser(Builder $query, int $userId): void
    {
        $query->where('user_id', $userId);
    }

    public function scopeIsStock(Builder $query, int $stockId): void
    {
        $query->where('stock_id', $stockId);
    }

    public function scopeIsNote(Builder $query, string $note): void
    {
        $query->where('note', $note);
    }

    public function scopeCurrentHoldings(Builder $query): void
    {
        $query->where('sold_out', 0);
    }

}
