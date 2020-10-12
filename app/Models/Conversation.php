<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Carbon\Carbon;

class Conversation extends Authenticatable {    
    protected $table = 'conversations';
    public $timestamps = false;
    
    protected $fillable = [
        'user1Id',   
        'user2Id',           
    ];  


}


