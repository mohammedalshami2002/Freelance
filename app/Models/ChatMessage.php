<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    use HasFactory;
    public static function boot() {
        parent::boot();
        static::creating(function (ChatMessage $message){
            $message->sender_id = auth()->id();
        });
    }

    protected $fillable = [
        'type',
        'content',
        'sender_id',
        'chat_id',
    ];

    protected $appends = [
        'is_my_message',
        'date_for_humans'
    ];

    public function getIsMyMessageAttribute() {
        return $this->sender_id == auth()->id();
    }

    public function getDateForHumansAttribute() {
        return $this->created_at->diffForHumans();
    }


    // **************** relationships *****************

    public function sender() {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function chat() {
        return $this->belongsTo(Chat::class);
    }
}
