<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'name',
        'email',
        'class_id',
        'section_id',
    ];

    protected $with = [
        'class',
        'section',
    ];

    public function class()
    {
        return $this->belongsTo(Classes::class, 'class_id');
    }

    public function section()
    {
        return $this->belongsTo(Sections::class, 'section_id');
    }
}
