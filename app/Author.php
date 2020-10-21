<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    protected $guarded = [];

    protected $dates = ['dob']; //converst all inputs entered into carbon instances

    public function setDobAttribute($dob)
    {
        $this->attributes['dob'] = Carbon::parse($dob);
    }
}
