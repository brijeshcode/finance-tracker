<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StockMeta extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [ 'stock_id',  'group_by', 'key', 'value'];


    public function stock(): BelongsTo
    {
        return $this->belongsTo(Stock::class);
    }
    /**
     * Scope a query to only include active clients.
     */
    public function scopeKey(Builder $query, string $key): void
    {
        $query->where('key', $key);
    }

    public function scopeIsGroup(Builder $query, string $group): void
    {
        $query->where('group_by', $group);
    }
}
