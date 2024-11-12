<?php

namespace App\Models\Investors;

use App\Models\Admin\Platform;
use App\Models\Admin\Stock;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CurrentHolding extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'platform_id', 'stock_id', 'quantity', 'average_price', 'current_value'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }

    public function platform(): BelongsTo
    {
        return $this->belongsTo(Platform::class);
    }
}
