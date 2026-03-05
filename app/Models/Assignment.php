<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id',
        'giver_id',
        'receiver_id',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function giver(): BelongsTo
    {
        return $this->belongsTo(Participant::class, 'giver_id');
    }

    public function receiver(): BelongsTo
    {
        return $this->belongsTo(Participant::class, 'receiver_id');
    }
}
