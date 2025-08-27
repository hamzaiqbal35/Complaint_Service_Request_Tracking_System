<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ComplaintLog extends Model
{
    use HasFactory;

    protected $fillable = ['complaint_id', 'user_id', 'action', 'message', 'meta'];

    protected $casts = [
        'meta' => 'array',
    ];

    public function complaint(): BelongsTo { return $this->belongsTo(Complaint::class); }
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
}


