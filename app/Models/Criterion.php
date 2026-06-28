<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Criterion extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'weight',
        'type',
        'unit',
        'description',
    ];

    protected function casts(): array
    {
        return [
            'weight' => 'float',
        ];
    }

    public function scores()
    {
        return $this->hasMany(RoadScore::class);
    }
}
