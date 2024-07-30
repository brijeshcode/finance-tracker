<?php

namespace App\Models\Investors;

use App\Models\Admin\Platform;
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
    
    protected $fillable = ['date', 'platform_id', 'user_id', 'stock_id', 'quantity', 'rate', 'price', 'net_profit', 'transaction_fee', 'note' ];

    protected $casts = [
        'quantity' => 'integer',
        'rate' => 'float',
        'price' => 'float',
        'net_profit' => 'float',
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

    public function scopeIsNote(Builder $query, string $note): void
    {
        $query->where('note', $note);
    }

}
