<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registrations extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'registration_time', 
    ];
    protected $hidden = [
        'ticket_id','citizen_id'
    ];
    function ticket(){
        return $this->belongsTo('App\Models\CampaignTickets');
    }
    function sessions(){
        return $this->belongsToMany('App\Models\Sessions','session_registrations','registration_id','session_id');
    }
}
