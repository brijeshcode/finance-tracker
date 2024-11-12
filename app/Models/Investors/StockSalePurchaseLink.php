<?php

namespace App\Models\Investors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockSalePurchaseLink extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['sale_id', 'purchase_id', 'quantity', 'profit_amount',];

    public function sale()
    {
        return $this->belongsTo(StockTransaction::class, 'sale_id');
    }

    public function purchase()
    {
        return $this->belongsTo(StockTransaction::class, 'purchase_id');
    }
 
}

 
