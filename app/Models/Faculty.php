<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Faculty extends Model
{
    protected $fillable = ['campus_id', 'name', 'dean', 'email', 'phone', 'website', 'description'];

    public function campus(): BelongsTo
    {
        return $this->belongsTo(Campus::class);
    }
}
