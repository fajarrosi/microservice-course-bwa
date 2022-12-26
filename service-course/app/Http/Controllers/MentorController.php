<?php

namespace App\Http\Controllers;

use App\Mentor;
use Illuminate\Http\Request;
use Validator;
use App\Traits\Response;

class MentorController extends Controller
{
    use Response;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Mentor::paginate(request('limit') ?: 15, ["*"], "page", request('page') ?: 1);
        return $this->successResponse($data, 'List Mentor');
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
            'profile' => 'required|url',
            'profession' => 'required|string',
            'email' => 'required|email',
            
        ];
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Mentor gagal ditambahkan',400);
        }

        $data = Mentor::create($request->all());
        return $this->successResponse($data,'Mentor Berhasil ditambahkan');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $rules = [
            'name' => 'string',
            'profile' => 'url',
            'profession' => 'string',
            'email' => 'email',
            
        ];
        $validator = Validator::make($request->all(),$rules);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors(),'Mentor gagal ditambahkan',400);
        }
        
        $data = Mentor::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Mentor not found',404);
        }

        $data->update($request->all());
        return $this->successResponse($data,'Mentor Berhasil diupdate');
    }

    public function show($id)
    {
        $data = Mentor::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Mentor not found',404);
        }

        return $this->successResponse($data,'Mentor Detail');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Mentor  $mentor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Mentor::find($id);

        if (!$data) {
            return $this->errorResponse(null,'Mentor not found',404);
        }

        $data->delete();

        return $this->successResponse(null,'Mentor berhasil dihapus');
    }
}
