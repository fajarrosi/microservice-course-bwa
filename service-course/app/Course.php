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
}
