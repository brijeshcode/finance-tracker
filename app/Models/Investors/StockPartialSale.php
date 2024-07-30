<?php

namespace App\Models\INvestors;

use App\Models\Investors\StockPurchase;
use App\Models\Investors\StockSale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockPartialSale extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['purchase_id', 'sale_id', 'date', 'quantity', 'rate', 'profit_on_sale'];
    

    protected $casts = [
        'rate' => 'float',
        'quantity' => 'integer',
        'profit_on_sale' => 'float',
    ];

    public function purchase(): BelongsTo
    {
        return $this->belongsTo(StockPurchase::class, 'purchase_id');
    }

    public function sale(): BelongsTo
    {
        return $this->belongsTo(StockSale::class, 'sale_id');
    }
    
}
