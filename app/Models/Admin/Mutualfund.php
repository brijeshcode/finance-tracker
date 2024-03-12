<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Mutualfund extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['name', 'type', 'market_cap', 'expense_ratio', 'exit_load', 'ltcg_tax_percent', 'ltcg_days', 'stcg_tax_percent', 'stcg_days', 'is_index_fund', 'note', 'active' ];

    protected $casts = [
        'active' => 'boolean',
        'is_index_fund' => 'boolean'
    ];

 
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeIndexFund(Builder $query): void
    {
        $query->where('is_index_fund', 1);
    }
}
