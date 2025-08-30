<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $fillable = ['description','price','status','user_id','project_id'] ;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Project()
    {
        return $this->belongsTo(Project::class);
    }
}
