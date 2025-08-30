<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DisputeMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'dispute_id',
        'user_id',
        'message',
        'attachment_path',
    ];

    /**
     * Get the dispute that the message belongs to.
     */
    public function dispute()
    {
        return $this->belongsTo(Dispute::class);
    }

    /**
     * Get the user that sent the message.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
