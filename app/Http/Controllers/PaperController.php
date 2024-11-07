<?php

namespace App\Http\Controllers;

use App\Models\Paper;
use App\Models\Quiz;
use App\Models\Setting;
use App\Models\Type;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaperController extends Controller
{
    public function index()
    {
        $allpapers = Paper::latest()->get();
        $formatArr = array();
        foreach ($allpapers as $paper) {
            $format = array();
            if ($paper->info) {
                
                $subformatArr = explode(",", $paper->info);    //subformatArr = [1-1-1,2-2-2,3-3-3]
                foreach ($subformatArr as $subformat) {
                    $subformat = explode("-", $subformat);   //subformat = 1-1-1
                    $name = Type::find($subformat[0])->name;    // name of type
                    $format[$name] = $subformat[1];     // count of type
                }
                
            }
            $formatArr[$paper->id] = $format;
        }
        return view("paper.index", [
            "papers" => $allpapers,
            "formatArr" => $formatArr
        ]);
    }

    public function store()
    {
        $paper = Paper::create([]);
        return redirect("/paper/$paper->id/configure");
    }

    public function configure(Paper $paper)
    {
        $setting = Setting::first();
        return view("paper.configure", [
            "paper" => $paper,
            "grades" => explode(",", $setting->grade),
            "img_list" => $setting->img_list ? explode(",", $setting->img_list) : null,
            "types" => Type::all(),
        ]);
    }

    public function update(Request $request)
    {
        try {
            Paper::where("id", $request->input("id"))->update([
                "name" => $request->input("name"),
                "header" => $request->input("header"),
                "header_img" => $request->input("header_img"),
                "grade" => $request->input("grade"),
                "time_allowed" => $request->input("time_allowed"),
                "total_mark" => $request->input("total_mark"),
                "info" => $request->input("info")
            ]);
            return response()->json(["message" => "🎉 Successfully saved the configuration info"], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "⚠️ Failed to save the data!!!"], 500);
        }
    }

    public function destroy(Paper $paper)
    {
        $name = $paper->name;
        try {
            Paper::where("id", $paper->id)->delete();
            return redirect("/paper")->with("success", "🎉 $name was successfully deleted 🎊");
        } catch (\Throwable $th) {
            return redirect("/paper")->with("error", "❗ Failed to delete the paper ❗");
        }
    }

    public function setupPaper(Paper $paper)
    {
        if (
            $paper->name == null
            || $paper->header == null
            || $paper->grade == null
            || $paper->time_allowed == null
            || $paper->total_mark == null
            || $paper->info == null
        ) {
            return redirect("/paper/$paper->id/configure")->with("warning", "⚠️ Configuration is not done yet!");
        } else {
            return view("paper.quizzes", [
                "paper" => $paper,
                "setting" => Setting::first()
            ]);
        }
    }

    public function setupQuizzes(Request $request)
    {
        try {
            $quizzes = Quiz::latest("id")
                ->filter(request(["type","grade","chapter"]))
                ->get();
            return response()->json(["data" => $quizzes], 200);
        } catch (Exception $e) {
            return response()->json(["error" => "⚠️ Failed to fetch the data!!"], 500);
        }

    }

    public function attachQuizzes(Request $request)
    {
        try {
            $paperId = $request->input("paperId");
            $quizzesId = $request->input("quizzesId");
            $emptyInfo = $request->input("emptyPositions");
            $emptyPositions = explode(",", $emptyInfo);

            $paper = Paper::find($paperId);
            if ($quizzesId == null) {
                return response()->json(["error" => "No Quiz Selected"], 500);
            }
            foreach ($paper->quizzes as $quiz) {
                if (in_array($quiz->id, explode(",", $quizzesId))) {
                    return response()->json(["error" => "Duplicate Entry!!!!"], 500);
                }
            }
            $index = 0;
            foreach (explode(",", $quizzesId) as $value) {
                $paper->attachQuiz($value, $emptyPositions[$index]);
                $index++;
            }

            return response()->json(["message" => "🎉Saved Changes🎊"], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }

    }

    public function detachQuizzes(Request $request)
    {
        try {
            Paper::find($request->input("paperId"))->detachQuiz($request->input("quizId"));
            return response()->json(["message" => "Removed"], 200);
        } catch (Exception $e) {
            return response()->json(["error" => $e->getMessage()], 500);
        }
    }

    public function renderPaper(Request $request)
    {
        try {
            $paper = Paper::find($request->input("paperId"));
            $formatInfo = array();
            foreach (explode(",", $paper->info) as $subformat) {
                $subformatArr = explode("-", $subformat);
                $type = Type::find($subformatArr[0]); //type id
                $formatInfo[] = [
                    "type" => $type,
                    "count" => $subformatArr[1],
                    "mark" => $subformatArr[2]
                ];
            }

            $quizzes = $paper->quizzes()
                ->orderBy("paper_quiz.position")
                ->get();

            $thewholepaper = array();
            foreach ($formatInfo as $format) {
                $section = [
                    "type_id" => $format["type"]->id,
                    "type_header" => $format["type"]->header,
                    "mark" => $format["mark"],
                    "count" => $format["count"]
                ];
                $temp = array();
                for ($i = 1; $i <= $format["count"]; $i++) {
                    $found = false;
                    foreach ($quizzes as $quiz) {
                        if ($format["type"]->id == $quiz->type->id && $i == $quiz->pivot->position) {
                            $found = true;
                            $temp[$quiz->pivot->position] = $quiz;
                        }
                    }
                    if ($found == false) {
                        $temp[$i] = "";
                    }
                }
                $section["body"] = $temp;
                $thewholepaper[] = $section;
            }

            return response()->json([
                "thewholepaper" => $thewholepaper
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                "error" => "Something is wrong in rendering server side!"
            ], 500);
        }
    }

    public function preview(Paper $paper){
        if (
            $paper->name == null
            || $paper->header == null
            || $paper->grade == null
            || $paper->time_allowed == null
            || $paper->total_mark == null
            || $paper->info == null
        ) {
            return redirect("/paper/$paper->id/configure")->with("warning", "⚠️ Configuration is not done yet!");
        }else{
            $formatInfo = array();
            foreach (explode(",", $paper->info) as $subformat) {
                $subformatArr = explode("-", $subformat);
                $type = Type::find($subformatArr[0]); //type id
                $formatInfo[] = [
                    "type" => $type,
                    "count" => $subformatArr[1],
                    "mark" => $subformatArr[2]
                ];
            }

            $quizzes = $paper->quizzes()
                ->orderBy("paper_quiz.position")
                ->get();

            $thewholepaper = array();
            foreach ($formatInfo as $format) {
                $section = [
                    "type_id" => $format["type"]->id,
                    "type_header" => $format["type"]->header,
                    "mark" => $format["mark"],
                    "count" => $format["count"]
                ];
                $temp = array();
                for ($i = 1; $i <= $format["count"]; $i++) {
                    $found = false;
                    foreach ($quizzes as $quiz) {
                        if ($format["type"]->id == $quiz->type->id && $i == $quiz->pivot->position) {
                            $found = true;
                            $temp[$quiz->pivot->position] = $quiz;
                        }
                    }
                    if ($found == false) {
                        $temp[$i] = "";
                    }
                }
                $section["body"] = $temp;
                $thewholepaper[] = $section;
            } 
            return view("paper.preview",[
                "paper" => $paper,
                "setting" => Setting::first(),
                "thewholepaper" => $thewholepaper
            ]);
        }
        
    }
}
