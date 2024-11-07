<?php

use App\Http\Controllers\GeneralController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/", [GeneralController::class, "index"]);

Route::get("/quiztype", [TypeController::class, "index"]);
Route::get("/quiztype/create", [TypeController::class, "create"]);
Route::post("/quiztype/create", [TypeController::class, "store"]);
Route::delete("/quiztype", [TypeController::class, "destroy"]);
Route::get("/quiztype/{type}/edit", [TypeController::class,"edit"]);
Route::put("/quiztype/{type}/edit", [TypeController::class,"update"]);

Route::get("/quiz", [QuizController::class,"index"]);
Route::delete("/quiz", [QuizController::class,"destroy"]);
Route::get("/quiz/create", [QuizController::class, "create"]);
Route::post("/quiz/create", [QuizController::class, "store"]);
Route::post("/quiz/create-multiple", [QuizController::class, "store_multiple"]);
Route::get("/quiz/{quiz}/edit", [QuizController::class, "edit"]);
Route::get("/quiz/{quiz}/edit/remove-img", [QuizController::class, "remove_img"]);
Route::put("/quiz/{quiz}/edit", [QuizController::class, "update"]);

Route::get("/paper", [PaperController::class, "index"]);
Route::post("/paper/create", [PaperController::class, "store"]);
Route::get("/paper/{paper}/configure", [PaperController::class, "configure"]);
Route::post("/paper/edit", [PaperController::class, "update"]);
Route::get("/paper/{paper}/delete", [PaperController::class, "destroy"]);
Route::get("/paper/{paper}/quizzes", [PaperController::class, "setupPaper"]);
Route::get("/paper/quizzes", [PaperController::class, "setupQuizzes"]);
Route::post("/paper/quizzes/attach", [PaperController::class, "attachQuizzes"]);
Route::get("/paper/render", [PaperController::class, "renderPaper"]);
Route::post("/paper/quizzes/detach", [PaperController::class, "detachQuizzes"]);
Route::get("/paper/{paper}/preview", [PaperController::class, "preview"]);

Route::get("/setting", [SettingController::class, "index"]);
Route::put("/setting/edit/subject", [SettingController::class, "editSubject"]);
Route::put("/setting/edit/grade", [SettingController::class, "editGrade"]);
Route::get("/setting/delete/grade/{grade}", [SettingController::class, "deleteGrade"]);
Route::put("/setting/edit/chapter", [SettingController::class, "editChapter"]);
Route::get("/setting/delete/chapter/{chapter}", [SettingController::class, "deleteChapter"]);
Route::put("/setting/image/upload", [SettingController::class, "upload"]);
Route::get("/setting/image/delete/{img}", [SettingController::class, "deleteImage"]);

Route::post("/export-database",[GeneralController::class, "exportDatabase"]);
Route::post("/import-database",[GeneralController::class, "importDatabase"]);