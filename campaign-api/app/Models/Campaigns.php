<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Campaigns extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'name', 'date', 'slug',
    ];
    protected $hidden = [
        'organizer_id',
    ];
    function tickets(){
        return $this->hasMany('App\Models\CampaignTickets','campaign_id');
    }
    function areas(){
        return $this->hasMany('App\Models\Areas','campaign_id');
    }
    function organizer(){
        return $this->belongsTo('App\Models\Organizers');
    }
    function formatDate(){
        return Carbon::parse($this->date)->format('F, j, Y');
    }
    function getNumRegis(){
        return Registrations::whereIn('ticket_id',CampaignTickets::where('campaign_id',$this->id)->get()->pluck('id'))->count();
    }
    function getRouteKeyName(){
        return 'slug';
    }
    function places(){
        return $this->hasManyThrough('App\Models\Places','App\Models\Areas','campaign_id','area_id');
    }
    function getSessions(){
        return Sessions::select('sessions.*')->join('places','sessions.place_id','places.id')
        ->join('areas','places.area_id','areas.id')
        ->where('campaign_id',$this->id)->get();
    }

}
