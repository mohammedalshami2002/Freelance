<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DurationTranslation extends Model
{
    use HasFactory;
    public $fillable=['duration_name'];
    public $timestamps = false;
}
