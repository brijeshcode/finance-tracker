<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CorporateAction extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['stock_id', 'type', 'bonus_ratio', 'split_ratio', 'value', 'record_date'];

}
