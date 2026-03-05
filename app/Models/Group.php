<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'budget',
        'event_date',
        'status',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
        'event_date' => 'date',
    ];

    public function participants(): HasMany
    {
        return $this->hasMany(Participant::class);
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(Assignment::class);
    }
}
