<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    public $fillable = ['username','email','phone','address','status','password'];
}
