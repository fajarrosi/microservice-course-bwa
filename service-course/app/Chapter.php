<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    protected $fillable = [
    'name','course_id'
    ];

    public function lessons()
    {
        return $this->hasMany('App\Lesson')->orderBy('id','ASC');
    }

    public function scopeFilterByCourse($query)
    {
        $courseId = request('course_id');
        $query->when($courseId, function($subquery) use ($courseId)
        {
            return $subquery->where('course_id', $courseId);
        });
    }
}
