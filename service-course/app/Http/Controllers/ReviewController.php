<?php

namespace App\Http\Controllers;

use App\Review;
use Illuminate\Http\Request;
use App\Course;
use App\Traits\Response;
use Validator;

class ReviewController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
            'course_id' => 'required|integer',
            'user_id' => 'required|integer',
            'rating' => 'required|integer|min:1|max:5',
            'note' => 'string',
            
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Review gagal ditambahkan',400);
        }

        $courseId = request('course_id');
        $course = Course::find($courseId);

        if (!$course) {
            return $this->errorResponse(null,'Course not found',404);
        }

        $userId = request('user_id');
        $user = getUser($userId);

        if ($user['status'] === 'error') {
            return $this->errorResponse(null,$user['message'],$user['http_code']);
        }

        $isExistMyCourse = Review::where('course_id',$courseId)->where('user_id',$userId)->exists();
        if ($isExistMyCourse) {
            return $this->errorResponse(null,'review already exist',409);
        }

        $data = Review::create($request->all());
        return $this->successResponse($data,'Review Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function show(Review $review)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function edit(Review $review)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'rating' => 'integer|min:1|max:5',
            'note' => 'string',
            
        ];

        $data = $request->except('user_id','course_id');

        $validator = Validator::make($data,$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Review gagal ditambahkan',400);
        }

        $review = Review::find($id);

        if (!$review) {
            return $this->errorResponse(null,'Review not found',404);
        }

        $review->update($data);
        return $this->successResponse($review,'Review Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Review::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Review not found',404);
        }

        $data->delete();

        return $this->successResponse(null,'Review berhasil dihapus');
    }
}
