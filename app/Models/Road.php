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
        'kelurahan',
        'kecamatan',
        'latitude',
        'longitude',
        'c1_panjang',
        'c2_lebar',
        'c3_kedalaman',
        'c4_lubang',
        'c5_kepentingan',
        'photo',
        'video',
        'notes',
    ];

    protected $casts = [
        'c1_panjang' => 'integer',
        'c2_lebar' => 'integer',
        'c3_kedalaman' => 'integer',
        'c4_lubang' => 'integer',
        'c5_kepentingan' => 'integer',
    ];

    public function getNameAttribute($value): string
    {
        return !empty($value) ? $value : ($this->location ?? 'Ruas Jalan');
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

    public static function getC1Options(): array
    {
        return [
            5 => '> 1000 cm',
            4 => '600 – 999 cm',
            3 => '300 – 599 cm',
            2 => '100 – 299 cm',
            1 => '< 100 cm',
        ];
    }

    public static function getC2Options(): array
    {
        return [
            5 => '≥ 600 cm',
            4 => '400 – 599 cm',
            3 => '300 – 399 cm',
            2 => '100 – 299 cm',
            1 => '< 100 cm',
        ];
    }

    public static function getC3Options(): array
    {
        return [
            5 => '≥ 8 cm',
            4 => '6 – 7.9 cm',
            3 => '4 – 5.9 cm',
            2 => '2 – 3.9 cm',
            1 => '< 2 cm',
        ];
    }

    public static function getC4Options(): array
    {
        return [
            5 => '≥ tidak beraturan',
            4 => '11 – 15 lubang',
            3 => '6 – 10 lubang',
            2 => '3 – 5 lubang',
            1 => '1 – 2 lubang',
        ];
    }

    public static function getC5Options(): array
    {
        return [
            5 => 'Rumah Sakit',
            4 => 'Sekolah / Pendidikan',
            3 => 'Kantor',
            2 => 'Pasar',
            1 => 'Lainnya',
        ];
    }

    public function getC1LabelAttribute(): string
    {
        return self::getC1Options()[$this->c1_panjang] ?? '-';
    }

    public function getC2LabelAttribute(): string
    {
        return self::getC2Options()[$this->c2_lebar] ?? '-';
    }

    public function getC3LabelAttribute(): string
    {
        return self::getC3Options()[$this->c3_kedalaman] ?? '-';
    }

    public function getC4LabelAttribute(): string
    {
        return self::getC4Options()[$this->c4_lubang] ?? '-';
    }

    public function getC5LabelAttribute(): string
    {
        return self::getC5Options()[$this->c5_kepentingan] ?? '-';
    }
}
