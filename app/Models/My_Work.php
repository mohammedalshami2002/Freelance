<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class My_Work extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'link',
        'image',
        'user_id'
    ];

     public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
