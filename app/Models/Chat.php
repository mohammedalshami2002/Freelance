<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_user',
        'second_user',
    ];

    // ***************** functions ***********************

    public function addMessage($data)
    {
        $message = new ChatMessage($data);
        $message->chat()->associate($this);
        return ($message->save());
    }


    /******************* relationships ***************** */

    public function messages()
    {
        return $this->hasMany(ChatMessage::class);
    }

    public function last_message()
    {
        return $this->hasOne(ChatMessage::class)->latest();
    }

    public function user()
    {
        if(auth()->id() == $this->first_user){
            return $this->belongsTo(User::class, 'second_user');
        } else {
            return $this->belongsTo(User::class, 'first_user');
        }
    }

    public function firstUser()
    {
        return $this->belongsTo(User::class, 'first_user');
    }

    public function secondUser()
    {
        return $this->belongsTo(User::class, 'second_user');
    }
}
