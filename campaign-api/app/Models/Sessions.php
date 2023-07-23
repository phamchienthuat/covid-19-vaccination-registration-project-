<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Sessions extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'title','description' ,'speaker','start','end','type','cost'
    ];
    protected $hidden = [
        'place_id',
    ];
    function sessionRegistrations(){
        return $this->hasMany('App\Models\SessionRegistrations','session_id');
    }
    function place(){
        return $this->belongsTo('App\Models\Places');
    }
    function getStart(){
        return Carbon::parse($this->start)->format('H:i');
    }
    function getEnd(){
        return Carbon::parse($this->end)->format('H:i');
    }
    function getAttendees(){
        if($this->type == 'talk'){
            return $this->place->area->campaign->getNumRegis();
        }
        elseif($this->type == 'workshop'){
            return SessionRegistrations::where('session_id',$this->id)->count();
        }
    }
}
