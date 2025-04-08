<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
    ];



    public function students()
{
    return $this->hasMany(Students::class, 'class_id');
}


    public function sections()
    {
        return $this->hasMany(Sections::class, 'class_id');
    }
}
