<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Places extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name','capacity' 
    ];
    protected $hidden = [
        'area_id','capacity'
    ];
    function sessions(){
        return $this->hasMany('App\Models\Sessions','place_id');
    }
    function area(){
        return $this->belongsTo('App\Models\Areas');
    }

}
