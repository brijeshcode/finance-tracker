<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Platform extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'platform_type_id'];

    public function scopeActive(Builder $query): void
    {
        $query->where('active', 1);
    }

    public function scopeInActive(Builder $query): void
    {
        $query->where('active', 0);
    }
}
