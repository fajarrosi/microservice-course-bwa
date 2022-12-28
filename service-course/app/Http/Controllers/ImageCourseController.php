<?php

namespace App\Http\Controllers;

use App\ImageCourse;
use Illuminate\Http\Request;
use App\Traits\Response;
use Validator;
use App\Course;

class ImageCourseController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'image' => 'required|string',
            'course_id' => 'required|integer',
            
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Image Course gagal ditambahkan',400);
        }

        $course = Course::find(request('course_id'));

        if (!$course) {
            return $this->errorResponse(null,'course not found',404);
        }


        $data = ImageCourse::create($request->all());
        return $this->successResponse($data,'Image Course Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ImageCourse  $imageCourse
     * @return \Illuminate\Http\Response
     */
    public function show(ImageCourse $imageCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ImageCourse  $imageCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(ImageCourse $imageCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ImageCourse  $imageCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ImageCourse $imageCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ImageCourse  $imageCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = ImageCourse::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Image Course not found',404);
        }

        $data->delete();

        return $this->successResponse(null,'Image Course berhasil dihapus');
    }
}
