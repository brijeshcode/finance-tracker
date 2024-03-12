<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['name', 'symbol', 'nse_code', 'bse_code', 'web_link', 'note', 'active' ];

    protected $casts = [
        'active' => 'boolean',
    ];

    /**
     * Scope a query to only include active clients.
     */
    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

}
