<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Novel extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function categories(){
        return $this->belongsToMany(Category::class);
    }

    public function chapters(){
        return $this->hasMany(Chapter::class);
    }
}
