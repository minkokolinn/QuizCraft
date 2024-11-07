<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = ["name","header","mark"];

    public function quizzes(){
        return $this->hasMany(Quiz::class);
    }
}
