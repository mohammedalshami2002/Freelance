<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Skill extends Model
{
    use HasFactory;
    use Translatable;
    protected $fillable =['name','categorie_id'];
    public $translatedAttributes =['name'];
    public function category() {
        return $this->belongsTo(Categorie::class);
    }
    public function users() {
        return $this->belongsToMany(User::class, 'skill__users');
    }
    public function projects() {
        return $this->belongsToMany(Project::class, 'project_skills');
    }
}
