<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    use HasFactory;
    public $timestamps = false;
    public $appends = ['token'];
    protected $fillable = [
        'firstname', 'lastname', 'username','email','registration_code','login_token'
    ];
    protected $hidden = [
        'id','login_token'
    ];
    function getTokenAttribute(){
        return $this->login_token;
    }
}
