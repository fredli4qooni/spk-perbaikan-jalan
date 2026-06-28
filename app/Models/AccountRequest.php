<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class AccountRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'requested_role',
        'notes',
        'status',
        'processed_by',
        'processed_at',
        'processed_notes',
        'processed_password',
    ];

    protected function casts(): array
    {
        return [
            'processed_at' => 'datetime',
        ];
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}