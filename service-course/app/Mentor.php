<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentor extends Model
{
    protected $fillable = [
        'name','profile','email','profession'
        ];
}
