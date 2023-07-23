<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class CampaignTickets extends Model
{
    use HasFactory;
    public $appends = ['description','available'];
    public $timestamps = false;
    protected $fillable = [
        'name', 'cost', 'special_validity',
    ];
    protected $hidden = [
        'campaign_id','special_validity'
    ];
    function registrations(){
        return $this->hasMany('App\Models\Registrations','ticket_id');
    }
    function campaign(){
        return $this->belongsTo('App\Models\Campaigns');
    }
    function getDescriptionAttribute(){
        $valid = json_decode($this->special_validity);
        if(!$valid){
            return null;
        }
        elseif($valid->type == 'amount'){
            return $valid->amount. " tickets available";
        }
        elseif($valid->type == 'date'){
            return 'Available until '.Carbon::parse($valid->date)->format('F j, Y');
        }
    }
    function getAvailableAttribute(){
        $valid = json_decode($this->special_validity);
        if(!$valid){
            return true;
        }
        elseif($valid->type == 'amount'){
            $ticket = Registrations::where('ticket_id',$this->id)->count();
            return $valid->amount > $ticket;
        }
        elseif($valid->type == 'date'){
            return $valid->date >= Carbon::now();
        }
    }

}
