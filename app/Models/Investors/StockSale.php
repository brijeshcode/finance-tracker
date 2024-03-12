<?php

namespace App\Models\Investors;

use App\Models\User;
use App\Models\Admin\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockSale extends Model
{
    use SoftDeletes;
    use HasFactory;


    protected $fillable = ['date', 'stock_transaction_id', 'stock_holding_id', 'user_id', 'stock_id', 'quantity',
            'rate', 'price', 'net_profit', 'note' ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
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

    public function scopeIsNote(Builder $query, string $note): void
    {
        $query->where('note', $note);
    }

}
