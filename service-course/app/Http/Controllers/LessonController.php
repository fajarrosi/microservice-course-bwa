<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use App\Traits\Response;
use Validator;
use App\Chapter;

class LessonController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Lesson::filterByChapter()->paginate(request('limit') ?: 15, ["*"], "page", request('page') ?: 1);
        return $this->successResponse($data, 'List Lesson');
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
            'video' => 'required|string',
            'chapter_id' => 'required|integer',
            
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Lesson gagal ditambahkan',400);
        }

        $chapter = Chapter::find(request('chapter_id'));

        if (!$chapter) {
            return $this->errorResponse(null,'Chapter not found',404);
        }


        $data = Lesson::create($request->all());
        return $this->successResponse($data,'Lesson Berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Lesson::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Lesson not found',404);
        }

        return $this->successResponse($data,'Lesson Detail');
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|string',
            'video' => 'required|string',
            'chapter_id' => 'required|integer',
        ];
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Lesson gagal ditambahkan',400);
        }
        
        $chapter = Chapter::find(request('chapter_id'));

        if (!$chapter) {
            return $this->errorResponse(null,'chapter not found',404);
        }

        $data = Lesson::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Lesson not found',404);
        }


        $data->update($request->all());
        return $this->successResponse($data,'Lesson Berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Lesson  $lesson
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Lesson::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Lesson not found',404);
        }

        $data->delete();

        return $this->successResponse(null,'Lesson berhasil dihapus');
    }
}
