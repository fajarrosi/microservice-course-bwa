<?php

namespace App\Http\Controllers;

use App\MyCourse;
use Illuminate\Http\Request;
use App\Course;
use App\Traits\Response;
use Validator;

class MyCourseController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = MyCourse::filterByUser()->with(['course'])->paginate(request('limit') ?: 15, ["*"], "page", request('page') ?: 1);
        return $this->successResponse($data, 'List Course');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createPremiumAccess(Request $request)
    {
        $myCourse = MyCourse::create($request->all());
        return $this->successResponse($myCourse,'Success');
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
            
        ];

        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'My Course gagal ditambahkan',400);
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

        $isExistMyCourse = MyCourse::where('course_id',$courseId)->where('user_id',$userId)->exists();
        if ($isExistMyCourse) {
            return $this->errorResponse(null,'user already taken the course',409);
        }

        if ($course->type === 'premium') {
            $order = postOrder([
                'user' => $user['data'],
                'course'=>$course->toArray()
            ]);
            // if($order['status'] === 'error'){
            //     return $this->errorResponse(null,$order['errors'],$order['http_code']);
            // }
            return $this->successResponse($order,'My Course Berhasil ditambahkan');
        }else{
            $data = MyCourse::create($request->all());
            return $this->successResponse($data,'My Course Berhasil ditambahkan');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\MyCourse  $myCourse
     * @return \Illuminate\Http\Response
     */
    public function show(MyCourse $myCourse)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\MyCourse  $myCourse
     * @return \Illuminate\Http\Response
     */
    public function edit(MyCourse $myCourse)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\MyCourse  $myCourse
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MyCourse $myCourse)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\MyCourse  $myCourse
     * @return \Illuminate\Http\Response
     */
    public function destroy(MyCourse $myCourse)
    {
        //
    }
}
