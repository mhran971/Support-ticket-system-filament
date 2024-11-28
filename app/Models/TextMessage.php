<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TextMessage extends Model
{
    protected $fillable = [
        'message',
        'response',
        'sent_to',
        'sent_by',
        'status',
    ];

    const STATUS = [
        'PENDING' => 'PENDING ',
        'SUCCESS'=>'SUCCESS',
        'FAILED'=>'FAILED'
    ];


    public function sentTo(): BelongsTo
    {
        return $this->belongsTo(User::class,'sent_to');
    }
    public function sentBy(): BelongsTo
    {
        return $this->belongsTo(User::class,'sent_to');
    }
}
