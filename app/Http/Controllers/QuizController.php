<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\Setting;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class QuizController extends Controller
{
    public function index()
    {
        $setting = Setting::first();
        return view("quiz.index", [
            "quizzes" => Quiz::latest("id")
                ->filter(request(["type","grade","chapter"]))
                ->get(),
            "selectedType" => request("type") ? Type::find(request("type")) : null,
            "grades" => explode(",", $setting->grade),
            "chapters" => explode(",", $setting->chapter)
        ]);
    }

    public function destroy()
    {
        $IdArr = explode(",", request("actionIds"));

        $allQuizzes = Quiz::whereIn("id", $IdArr)->get();
        foreach ($allQuizzes as $quiz) {
            if ($quiz->image) {
                $imagePath = public_path("uploads/" . $quiz->image);
                if (File::exists($imagePath)) {
                    File::delete($imagePath);
                }
            }
        }

        Quiz::whereIn("id", $IdArr)->delete();

        return request("type") ? redirect("/quiz?type=" . request("type")) : redirect("/quiz");
    }

    public function create()
    {
        $setting = Setting::first();
        if (request("type")) {
            return view("quiz.form", [
                "selectedType" => request("type") ? Type::find(request("type")) : null,
                "grades" => explode(",", $setting->grade),
                "chapters" => explode(",", $setting->chapter)
            ]);
        } else {
            abort(404);
        }
    }

    public function store()
    {    // Storing For single entry
        $data = [];
        if (request("type") == 3) {    // if data from mcq
            request()->validate([
                "grade" => ["required", "integer"],
                "chapter" => ["required", "integer"],
                "body" => ["required"],
                "A" => ["required"],
                "B" => ["required"],
                "C" => ["required"],
                "D" => ["required"]
            ]);
            $jsonArr = ["body" => request("body"), "A" => request("A"), "B" => request("B"), "C" => request("C"), "D" => request("D")];
            $data["body"] = json_encode($jsonArr);
        } else {
            request()->validate([
                "grade" => ["required", "integer"],
                "chapter" => ["required", "integer"],
                "body" => ["required"]
            ]);
            $data["body"] = request("body");
        }
        $data["grade"] = request("grade");
        $data["chapter"] = request("chapter");
        $data["type_id"] = request("type");

        if (request()->file("image")) {
            request()->validate([
                "image" => ["mimes:png,jpg,jpeg,gif,webp"]
            ]);
            $image = request()->file("image");
            $imageName = "Q-" . rand(1000, 9999) . "-" . $image->getClientOriginalName();
            try {
                $image->move(public_path("uploads"), $imageName);
            } catch (\Exception $fe) {
                return back()->with("error", $fe->getMessage());
            }
            $data["image"] = $imageName;
        }
        try {
            Quiz::create($data);
            return redirect("/quiz/create?type=" . request("type"))->with("success", "🎉A new quiz was successfully added🎊");
        } catch (\Exception $e) {
            return redirect("/quiz/create?type=" . request("type"))->with("error", "Failed to create a new quiz!");
        }
    }

    public function store_multiple()
    {
        request()->validate([
            "grade" => ["required", "integer"],
            "chapter" => ["required", "integer"],
            "separator" => ["required"],
            "import" => ["required"]
        ]);
        $multiple_quizzes = request("dynamic_input");
        $dataArr = [];
        foreach ($multiple_quizzes as $quiz) {
            $data = [];
            $data["body"] = $quiz;
            $data["type_id"] = request("type");
            $data["grade"] = request("grade");
            $data["chapter"] = request("chapter");
            $data["created_at"] = now();
            $data["updated_at"] = now();
            $dataArr[] = $data;
        }

        // inserting all these rows
        try {
            Quiz::insert($dataArr);
            return redirect("/quiz/create?type=" . request("type") . "&&multiple=on")->with("success", "🎉" . count($dataArr) . " quizzes were successfully inserted🎊");
        } catch (\Exception $e) {
            return redirect("/quiz/create?type=" . request("type") . "&&multiple=on")->with("error", "Failed to create a new quiz!");
        }
    }

    public function edit(Quiz $quiz)
    {
        $setting = Setting::first();
        return view("quiz.form-edit", [
            "quiz" => $quiz,
            "grades" => explode(",", $setting->grade),
            "chapters" => explode(",", $setting->chapter)
        ]);
    }

    public function remove_img(Quiz $quiz)
    {
        $imagePath = public_path("uploads/" . $quiz->image);
        if (File::exists($imagePath)) {
            File::delete($imagePath);

            Quiz::where("id",$quiz->id)->update(["image"=>null]);
        }
        return back();
    }

    public function update(Quiz $quiz){
        $data = [];
        if ($quiz->type->id == 3) {    // if data from mcq
            request()->validate([
                "grade" => ["required", "integer"],
                "chapter" => ["required", "integer"],
                "body" => ["required"],
                "A" => ["required"],
                "B" => ["required"],
                "C" => ["required"],
                "D" => ["required"]
            ]);
            $jsonArr = ["body" => request("body"), "A" => request("A"), "B" => request("B"), "C" => request("C"), "D" => request("D")];
            $data["body"] = json_encode($jsonArr);
        } else {
            request()->validate([
                "grade" => ["required", "integer"],
                "chapter" => ["required", "integer"],
                "body" => ["required"]
            ]);
            $data["body"] = request("body");
        }
        $data["grade"] = request("grade");
        $data["chapter"] = request("chapter");

        if (request()->file("image")) {
            request()->validate([
                "image" => ["mimes:png,jpg,jpeg,gif,webp"]
            ]);
            $image = request()->file("image");
            $imageName = "Q-" . rand(1000, 9999) . "-" . $image->getClientOriginalName();
            try {
                $image->move(public_path("uploads"), $imageName);
            } catch (\Exception $fe) {
                return back()->with("error", $fe->getMessage());
            }
            $data["image"] = $imageName;
        }
        try {
            Quiz::where("id", $quiz->id)->update($data);
            return redirect("/quiz/$quiz->id/edit")->with("success", "🎉Successfully updated...🎊");
        } catch (\Exception $e) {
            return redirect("/quiz/$quiz->id/edit")->with("error", "Failed to update the quiz!");
        }
        
    }

}
