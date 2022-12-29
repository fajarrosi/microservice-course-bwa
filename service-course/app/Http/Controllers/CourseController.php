<?php

namespace App\Http\Controllers;

use App\Course;
use Illuminate\Http\Request;
use App\Traits\Response;
use Validator;
use App\Mentor;
use App\Review;
use App\MyCourse;
use App\Chapter;

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
        $data = Course::filterByKeyword()->filterByStatus()->paginate(request('limit') ?: 15, ["*"], "page", request('page') ?: 1);
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
        $data = Course::with(['mentor','images','chapters.lessons'])->find($id);
        
        if (!$data) {
            return $this->errorResponse(null,'Course not found',404);
        }

        $reviews = Review::where('course_id',$id)->get()->toArray();
        if(count($reviews) > 0){
            $userIds = array_column($reviews,'user_id');
            $users = getUserByIds($userIds);
            if($users['status'] === 'error'){
                return $this->errorResponse(null,$users['message'],$users['http_code']);
            }
            foreach ($reviews as $key => $review) {
                $userIndex = array_search($review['user_id'],array_column($users['data'],'id'));
                $reviews[$key]['user'] = $users['data'][$userIndex];
            }
        }
        $totalStudent = MyCourse::where('course_id',$id)->count();
        $totalVideo = Chapter::where('course_id',$id)->withCount('lessons')->get()->toArray();
        $finalTotalVideo = array_sum(array_column($totalVideo,'lessons_count'));
        $data['reviews'] = $reviews;
        $data['total_videos'] = $finalTotalVideo;
        $data['total_student'] = $totalStudent;

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
    public function destroy($id)
    {
        $data = Course::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Course not found',404);
        }

        $data->delete();

        return $this->successResponse(null,'Course berhasil dihapus');
    }
}
