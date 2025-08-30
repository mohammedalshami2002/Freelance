<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;

class Categorie extends Model
{
    use HasFactory;
    use Translatable;
    protected $fillable =['name','description'];
    public $translatedAttributes =['name','description'];
    public function skill()
    {
        return $this->hasMany(Skill::class);
    }
    public function services()
    {
        return $this->hasMany(Service::class);
    }
    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
