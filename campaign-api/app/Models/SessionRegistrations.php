<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionRegistrations extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
       
    ];
    protected $hidden = [
        'registration_id','session_id'
    ];
    function registration(){
        return $this->belongsTo('App\Models\Registrations');
    }
    function session(){
        return $this->belongsTo('App\Models\Sessions');
    }
}
