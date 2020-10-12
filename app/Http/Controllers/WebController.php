<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Fuente;
use App\Models\Suscripcion;


use Illuminate\Support\Collection as Collection;
use Response;
use Storage;
use App;
use Carbon\Carbon;
use Redirect;
use Image;
use URL;
use View;
use Auth;
use Session;

class WebController extends Controller{
    
    public function __construct(){
        // $this->middleware('auth'); 
    }
    
    public function index(){
        return view('login');
    }

    public function home() {
        $validar = 'Inicio';        
        $titulo = 'Home';
        return view('auth.login',compact('titulo','validar'));
    }
    
}
