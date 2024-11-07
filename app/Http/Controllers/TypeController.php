<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TypeController extends Controller
{
    public function index()
    {
        return view("quiztype.index", [
            "types" => Type::all()
        ]);
    }

    public function create()
    {
        return view("quiztype.form");
    }

    public function store()
    {
        $formData = request()->validate([
            "name" => ["required", Rule::unique("types", "name")],
            "mark" => ["required", "max:10"],
            "header" => ["required", "max:255"]
        ]);
        Type::create($formData);
        return redirect("/quiztype/create")->with("success", "🎉A new quiz type was successfully added🎊");
    }

    public function destroy()
    {
        $IdArr = explode(",", request("actionIds"));
        Type::whereIn("id", $IdArr)->delete();
        return redirect("/quiztype");
    }

    public function edit(Type $type)
    {
        return view("quiztype.form", [
            "type" => $type
        ]);
    }

    public function update(Type $type)
    {
        $formData = request()->validate([
            "name" => ["required"],
            "mark" => ["required"],
            "header" => ["required"]
        ]);
        try {
            Type::where("id", $type->id)->update($formData);
        } catch (\Exception $e) {
            return redirect("/quiztype/" . $type->id . "/edit")->with("error", "❗ Duplicate entry Error ❗");
        }
        return redirect("/quiztype/" . $type->id . "/edit")->with("success", "🎉Successfully Edited.🎊");
    }
}
