<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Carbon\Carbon;

class User extends Authenticatable {        

    protected $table = 'users';
    public $timestamps = false;

    protected $fillable = [        
        'name',        
        'email',        
        'password',                   
    ];                        

}


