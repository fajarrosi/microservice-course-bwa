<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MyCourse extends Model
{
    protected $fillable = [
        'user_id','course_id'
        ];

    public function course()
    {
        return $this->belongsTo('App\Course');
    }
}
