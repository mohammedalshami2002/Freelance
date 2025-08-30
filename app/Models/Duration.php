<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duration extends Model
{
    use HasFactory;
    use Translatable;
    protected $fillable =['duration_name','number'];
    public $translatedAttributes =['duration_name'];

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
