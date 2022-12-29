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

    public function scopeFilterByUser($query)
    {
        $userId = request('user_id');
        $query->when($userId, function($subquery) use ($userId)
        {
            return $subquery->where('user_id', $userId);
        });
    }
}
