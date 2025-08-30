<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile_Service_provider extends Model
{
    use HasFactory;
    protected $fillable = [
        'profile',
        'phone_number',
        'university_name',
        'specialization',
        'authenticated',
        'review',
        'user_id',
        'categorie_id',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function category() {
        return $this->belongsTo(Categorie::class);
    }
}
