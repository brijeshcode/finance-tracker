<?php

namespace App\Models\Investors;

use App\Models\User;
use App\Models\Admin\Stock;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockPortfolio extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['user_id', 'stock_id', 'quantity', 'avg_rate', 'invested_value', 'long_term_quantities', 'total_divident_earns', 'note' ];

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function investor(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
