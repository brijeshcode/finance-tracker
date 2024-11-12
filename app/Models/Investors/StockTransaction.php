<?php

namespace App\Models\Investors;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockTransaction extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['user_id', 'platform_id', 'stock_id', 'type', 'quantity', 'price', 'total'];
}
