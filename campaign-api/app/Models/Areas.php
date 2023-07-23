<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Areas extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name', 
    ];
    protected $hidden = [
        'campaign_id',
    ];
    function places(){
        return $this->hasMany('App\Models\Places','area_id');
    }
    function campaign(){
        return $this->belongsTo('App\Models\Campaigns');
    }
    function sessions(){
        return $this->hasManyThrough('App\Models\Sessions','App\Models\Places','area_id','place_id');
    }

}
