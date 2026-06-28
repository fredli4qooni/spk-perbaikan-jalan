<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'location',
        'survey_year',
        'photo',
        'notes',
        'length',
        'width',
        'holes_count',
        'hole_depth',
        'importance',
        'kelurahan',
        'kecamatan',
        'rt',
        'is_verified',
        'verified_by',
        'verified_at',
    ];

    protected function casts(): array
    {
        return [
            'is_verified' => 'boolean',
            'verified_at' => 'datetime',
        ];
    }

    public function scores()
    {
        return $this->hasMany(RoadScore::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
}
