<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $with = ["type"];

    protected $guarded = ["id"];

    public function type(){
        return $this->belongsTo(Type::class);
    }

    public function papers(){
        return $this->belongsToMany(Paper::class)->withPivot("position");
    }

    public function scopeFilter($query, $request){
        $query->when($request["type"] ?? false, function($query,$type){ //$type is selected id of type
            $query->whereHas("type", function($query) use ($type){
                $query->where("id",$type);
            });
        });
        $query->when($request["grade"] ?? false, function($query,$grade){
            $query->where("grade",$grade);
        });
        $query->when($request["chapter"] ?? false, function($query,$chapter){
            $query->where("chapter",$chapter);
        });
    }

    // public function scopeFilter($query, $filter)
    // {
    //     $query->when($filter["search"] ?? false, function ($query, $search) {
    //         $query->where(function ($query) use ($search) {   // this is logical grouping
    //             $query->where("title", "LIKE", "%" . $search . "%")
    //                 ->orWhere("body", "LIKE", "%" . $search . "%");
    //         });
    //     });
    //     $query->when($filter["category"] ?? false, function ($query, $category) {
    //         $query->whereHas("category", function ($query) use ($category) {
    //             $query->where("slug", $category);
    //         });
    //     });
    //     $query->when($filter["author"] ?? false, function ($query, $author) {
    //         $query->whereHas("author", function ($query) use ($author) {
    //             $query->where("username", $author);
    //         });
    //     });
    // }
}
