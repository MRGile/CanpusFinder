<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Campus extends Model
{
    protected $fillable = [
        'slug', 'abbreviation', 'name', 'city', 'province', 'address', 'website', 'email', 'phone',
        'founded_year', 'description', 'image_path', 'logo_path', 'program_count', 'type', 'accreditation', 'rank',
    ];

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('name');
    }

    public function typeBadgeClass(): string
    {
        return match ($this->type) {
            'Swasta' => 'badge-swasta',
            'Vokasi' => 'badge-vokasi',
            'Kedinasan' => 'badge-kedinasan',
            default => 'badge-negeri',
        };
    }

    public function favoritedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'campus_user_favorites')->withTimestamps();
    }

    public function faculties(): HasMany
    {
        return $this->hasMany(Faculty::class);
    }

    public function contents(): HasMany
    {
        return $this->hasMany(CampusContent::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(CampusReview::class);
    }
}
