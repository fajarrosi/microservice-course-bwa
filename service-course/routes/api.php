<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\MentorController;
// use    ChapterController,
// use    CourseController,
// use    ImageCourseController,
// use    LessonController,
// use   MyCourseController,
// use   ReviewController,


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::apiResource('mentors', MentorController::class);
Route::apiResource('courses', CourseController::class);