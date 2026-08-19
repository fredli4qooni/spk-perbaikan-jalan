<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Road extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'location',
        'survey_year',
        'photo',
        'video',
        'notes',
        'length',
        'width',
        'holes_count',
        'potholes_data',
        'importance',
        'distance',
        'latitude',
        'longitude',
        'kelurahan',
        'kecamatan',
        'rt',
    ];

    protected function casts(): array
    {
        return [
            'potholes_data' => 'array',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function scores()
    {
        return $this->hasMany(RoadScore::class);
    }
}
