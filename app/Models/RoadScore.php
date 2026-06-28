<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoadScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'road_id',
        'criterion_id',
        'value',
        'notes',
    ];

    protected function casts(): array
    {
        return [
            'value' => 'float',
        ];
    }

    public function road()
    {
        return $this->belongsTo(Road::class);
    }

    public function criterion()
    {
        return $this->belongsTo(Criterion::class);
    }
}
