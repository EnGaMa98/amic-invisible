<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'name',
        'email',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }
}
