<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paper extends Model
{
    use HasFactory;

    protected $guarded = ["id"];

    public function quizzes(){
        return $this->belongsToMany(Quiz::class,"paper_quiz")->withPivot("position");
    }

    public function attachQuiz($quizId, $position){
        $this->quizzes()->attach($quizId, ["position"=>$position]);
    }

    public function detachQuiz($quizId){
        $this->quizzes()->detach($quizId);
    }
}
