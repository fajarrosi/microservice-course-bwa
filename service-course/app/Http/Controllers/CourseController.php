<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use App\Traits\Response;
use Validator;
use App\Mentor;

class CourseController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Course::filterByKeyword(request('keyword'))->paginate(request('limit') ?: 15, ["*"], "page", request('page') ?: 1);
        return $this->successResponse($data, 'List Course');
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
            'name' => 'required|string',
            'certificate' => 'required|boolean',
            'thumbnail' => 'required|url',
            'type' => 'required|in:free,premium',
            'status' => 'required|in:draft,published',
            'level' => 'required|in:all-level,beginner,intermediate,advance',
            'price' => 'integer',
            'description' => 'string',
            'mentor_id' => 'required|integer',
            
        ];
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Course gagal ditambahkan',400);
        }

        $mentor = Mentor::find(request('mentor_id'));

        if (!$mentor) {
            return $this->errorResponse(null,'mentor not found',404);
        }


        $data = Course::create($request->all());
        return $this->successResponse($data,'Course Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Course::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Course not found',404);
        }

        return $this->successResponse($data,'Course Detail');
    }

  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'certificate' => 'boolean',
            'thumbnaiil' => 'url',
            'type' => 'in:free,premium',
            'status' => 'in:draft,published',
            'level' => 'in:all-level,beginner,intermediate,advance',
            'price' => 'integer',
            'description' => 'string',
            'mentor_id' => 'integer',
            
        ];
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Course gagal ditambahkan',400);
        }
        
        $data = Course::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Course not found',404);
        }

        $mentor = Mentor::find(request('mentor_id'));

        if (!$mentor) {
            return $this->errorResponse(null,'mentor not found',404);
        }

        $data->update($request->all());
        return $this->successResponse($data,'Course Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Course  $course
     * @return \Illuminate\Http\Response
     */
    public function destroy(Course $course)
    {
        $data = Course::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Course not found',404);
        }

        $data->delete();

        return $this->successResponse(null,'Course berhasil dihapus');
    }
}
