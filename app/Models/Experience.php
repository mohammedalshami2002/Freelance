<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Experience extends Model
{
    use HasFactory;
    use Translatable;

    protected $fillable =['name'];
    public $translatedAttributes =['name'];

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
