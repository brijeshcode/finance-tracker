<?php

namespace App\Traits;

use App\GlobalScopes\ActiveScope;

trait Activeable
{
    public static function bootActiveable()
    {
        static::addGlobalScope(new ActiveScope);
    }
}
