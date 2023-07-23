<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Organizers extends Authenticatable
{
    use HasFactory;
    public $rememberTokenName = false;
    public $timestamps = false;
    protected $fillable = [
        'name', 'email', 'slug',
    ];
    protected $hidden = [
        'password_hash','email'
    ];
    function campaigns(){
        return $this->hasMany('App\Models\Campaigns','organizer_id')->orderBy('date','asc');
    }
    function getAuthPassword(){
        return $this->password_hash;
    }
}
