<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'email',
        'token',
        'preferences',
    ];

    protected $hidden = [
        'token',
    ];

    public static function generateToken(): string
    {
        return Str::random(64);
    }

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
