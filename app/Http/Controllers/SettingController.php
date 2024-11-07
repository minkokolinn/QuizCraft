<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SettingController extends Controller
{
    public function index()
    {
        return view("setting", [
            "setting" => Setting::first()
        ]);
    }

    public function editSubject()
    {
        $formData = request()->validate([
            "subject" => ["required"]
        ]);
        try {
            Setting::first()->update([
                "subject" => $formData["subject"]
            ]);
            return redirect("/setting")->with("success", "Saved subject..");
        } catch (\Exception $e) {
            return redirect("/setting")->with("error", $e->getMessage());
        }
    }

    public function editGrade()
    {
        $formData = request()->validate([
            "grade" => ["required"]
        ]);
        $setting = Setting::first();
        $gradeStr = $setting->grade;
        if ($gradeStr == null) {
            $gradeArr = [$formData["grade"]];
        } else {
            $gradeArr = explode(",", $gradeStr);
            $gradeArr[] = $formData["grade"];
        }
        try {
            $setting->update([
                "grade" => implode(",", $gradeArr)
            ]);
            return redirect("/setting")->with("success", "Saved Grade..");
        } catch (\Exception $e) {
            return redirect("/setting")->with("error", $e->getMessage());
        }
    }

    public function deleteGrade(string $grade)
    {
        $setting = Setting::first();
        $gradeStr = $setting->grade;
        $gradeArr = explode(",", $gradeStr);
        unset($gradeArr[array_search($grade, $gradeArr)]);
        try {
            $setting->update([
                "grade" => implode(",", $gradeArr)
            ]);
            return redirect("/setting")->with("success", "Removed Grade..");
        } catch (\Exception $e) {
            return redirect("/setting")->with("error", $e->getMessage());
        }
    }

    public function editChapter()
    {
        $formData = request()->validate([
            "chapter" => ["required"]
        ]);
        $setting = Setting::first();
        $chapterStr = $setting->chapter;
        if ($chapterStr == null) {
            $chapterArr = [$formData["chapter"]];
        } else {
            $chapterArr = explode(",", $chapterStr);
            $chapterArr[] = $formData["chapter"];
        }
        try {
            $setting->update([
                "chapter" => implode(",", $chapterArr)
            ]);
            return redirect("/setting")->with("success", "Saved Chapter..");
        } catch (\Exception $e) {
            return redirect("/setting")->with("error", $e->getMessage());
        }
    }

    public function deleteChapter(string $chapter)
    {
        $setting = Setting::first();
        $chapterStr = $setting->chapter;
        $chapterArr = explode(",", $chapterStr);
        unset($chapterArr[array_search($chapter, $chapterArr)]);
        try {
            $setting->update([
                "chapter" => implode(",", $chapterArr)
            ]);
            return redirect("/setting")->with("success", "Removed Chapter..");
        } catch (\Exception $e) {
            return redirect("/setting")->with("error", $e->getMessage());
        }
    }

    public function upload()
    {
        request()->validate([
            "image" => ["required", "mimes:png,jpg,jpeg,gif,webp"]
        ]);

        try {
            $image = request()->file("image");
            $imageName = rand(1000, 9999). "-" .$image->getClientOriginalName();
            $image->move(public_path("uploads"), $imageName);

            $setting = Setting::first();
            $imgStr = $setting->img_list;
            if ($imgStr == null) {
                $imgArr = [$imageName];
            } else {
                $imgArr = explode(",", $imgStr);
                $imgArr[] = $imageName;
            }
            $setting->update([
                "img_list" => implode(",",$imgArr)
            ]);
            return redirect("/setting")->with("success","Image uploaded..");
        } catch (\Exception $e) {
            return redirect("/setting")->with("error",$e->getMessage());
        }
    }

    public function deleteImage(string $img){
        $imagePath = public_path("uploads/".$img);
        if(File::exists($imagePath)){
            File::delete($imagePath);

            $setting = Setting::first();
            $imgStr = $setting->img_list;
            $imgArr = explode(",",$imgStr);
            unset($imgArr[array_search($img,$imgArr)]);
            $setting->update([
                "img_list" => implode(",",$imgArr)
            ]);
            return redirect("/setting")->with("success","File Deleted..");
        }else{
            return redirect("/setting")->with("error","File Does not exists");
        }
    }
}
