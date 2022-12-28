<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'name','video','chapter_id'
        ];

    public function scopeFilterByChapter($query)
    {
        $chapterId = request('chapter_id');
        $query->when($chapterId, function($subquery) use ($chapterId)
        {
            return $subquery->where('chapter_id', $chapterId);
        });
    }
}
