<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Forget_password extends Model
{
    use HasFactory;
protected $fillable = ['code_verifie','verification_expires_at','user_id'];
}
