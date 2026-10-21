<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CampusContent extends Model
{
    protected $fillable = ['kind', 'title', 'subtitle', 'description', 'value', 'icon', 'color', 'text_color', 'metric', 'sort_order'];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
