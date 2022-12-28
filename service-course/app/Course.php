<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name','certificate','thumbnaiil',
        'type','status','level','price','description','mentor_id'
    ];

    public function mentor()
    {
        return $this->belongsTo('App\Mentor');
    }

    public function chapters()
    {
        return $this->hasMany('App\Chapter')->orderBy('id','ASC');
    }
    
    public function images()
    {
        return $this->hasMany('App\ImageCourse')->orderBy('id','DESC');
    }

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s',
    ];

    public function scopeFilterByKeyword($query)
    {
        $keyword = request('keyword');
        $query->when($keyword, function($subquery) use ($keyword)
        {
            return $subquery->where('name', 'like', "%" . $keyword . "%");
        });
    }
    public function scopeFilterByStatus($query)
    {
        $status = request('status');
        $query->when($status, function($subquery) use ($status)
        {
            return $subquery->where('status', $status);
        });
    }
}
