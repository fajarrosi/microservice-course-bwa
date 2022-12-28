<?php

namespace App\Http\Controllers;

use App\Chapter;
use Illuminate\Http\Request;
use App\Traits\Response;
use Validator;
use App\Course;

class ChapterController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Chapter::filterByCourse()->paginate(request('limit') ?: 15, ["*"], "page", request('page') ?: 1);
        return $this->successResponse($data, 'List Chapter');
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
            'course_id' => 'required|integer',
            
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Chapter gagal ditambahkan',400);
        }

        $course = Course::find(request('course_id'));

        if (!$course) {
            return $this->errorResponse(null,'course not found',404);
        }


        $data = Chapter::create($request->all());
        return $this->successResponse($data,'Chapter Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Chapter::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Chapter not found',404);
        }

        return $this->successResponse($data,'Chapter Detail');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'string',
            'course_id' => 'integer',
        ];
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Chapter gagal ditambahkan',400);
        }
        
        $course = Course::find(request('course_id'));

        if (!$course) {
            return $this->errorResponse(null,'course not found',404);
        }

        $data = Chapter::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Chapter not found',404);
        }


        $data->update($request->all());
        return $this->successResponse($data,'Chapter Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Chapter  $chapter
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Chapter::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Chapter not found',404);
        }

        $data->delete();

        return $this->successResponse(null,'Chapter berhasil dihapus');
    }
}
