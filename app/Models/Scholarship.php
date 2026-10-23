<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    public const ALL_CAMPUSES = '__all_campuses__';
    public const ALL_STUDY_LEVEL = 'Semua jenjang';

    protected $fillable = [
        'name', 'provider', 'scholarship_type', 'amount', 'deadline', 'deadline_label', 'study_level',
        'recipient_count', 'description', 'application_url', 'eligible_universities',
        'requirements', 'benefits', 'required_documents', 'emoji',
        'background_color', 'text_color', 'badge_color',
    ];

    protected function casts(): array
    {
        return ['deadline' => 'date'];
    }

    public function scopeNotExpired(Builder $query): Builder
    {
        return $query->whereNotNull('deadline')->whereDate('deadline', '>=', today('Asia/Jakarta'));
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('deadline')->orderBy('name');
    }

    public function eligibleUniversitiesLabel(): string
    {
        return $this->eligible_universities === self::ALL_CAMPUSES
            ? 'Semua universitas/sekolah'
            : (string) $this->eligible_universities;
    }
}
