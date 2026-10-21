<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function scopeLatest(Builder $query): Builder
    {
        return $query->orderByDesc('published_at');
    }
}
