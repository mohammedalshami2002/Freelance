<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'description', 'status', 'prise', 'user_id', 'categorie_id', 'experience_id', 'duration_id','receiver_user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categorie()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function experience()
    {
        return $this->belongsTo(Experience::class);
    }
    public function duration()
    {
        return $this->belongsTo(Duration::class);
    }
    public function offer()
    {
        return $this->hasMany(Offer::class);
    }
    public function skills() {
        return $this->belongsToMany(Skill::class, 'project_skills');
    }
    public function ratings() {
        return $this->hasMany(Rating::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transactions::class);
    }
}
