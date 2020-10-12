<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use App\Models\Configuracion;
use App\Models\Geopoint;
use App\Models\User;
use anlutro\cURL\cURL;
use App\Models\Driver;
use App\Http\Requests;
use App\Http\Helpers;
use Carbon\Carbon;
use App\Models\Conversation;
use App\Events\VideoChatEvent;

use Exception;
use DateTime;
use Redirect;
use Session;
use Config;
use Route;
use Request;
use Auth;
use form;
use View;
use URL;
use DB;


class VideoChatController extends Controller {
     
   public function chatVideoCall($conversationId) {        
      $conversation = Conversation::find($conversationId);
      $currentUser = Auth::user();         
      return view('chatVideoCall', compact('conversation','currentUser'));        
   }

   public function send($conversationId) {        
      $conversation = Conversation::find($conversationId);      
      $currentUserId = Auth::user()->id;   
      $data = Request::all();         
      $data['to'] = $data['receiverId'];      
      $channel = 'chat_send.'.$conversationId;         
      broadcast(new VideoChatEvent($data, $channel));                          
   }

   public function getConversacion($conversationId) {
      $conversation = Conversation::find($conversationId);
      $currentUser = Auth::user();                           
      return view('VideoLlamada', compact('conversation','currentUser'));
   }

   public function startVideoCall($conversationId) {                  
      $receiverUserId = 0;
      $currentUserId = Auth::user()->id;                  
      $channel = 'video_call_start.'.$conversationId;         
      $conversation = Conversation::find($conversationId);         
      $data = Request::all();               
      $data['to'] = $data['receiverId'];          
      broadcast(new VideoChatEvent($data, $channel));
   }
   
   public function hangVideoCall($conversationId) {    
      $receiverUserId = 0;
      $currentUserId = Auth::user()->id;      
      $channel = 'video_call_hang.'.$conversationId;      
      $conversation = Conversation::find($conversationId);
      $data = Request::all();         
      $data['to'] = $data['receiverId'];                        
      event(new VideoChatEvent($data, $channel));
   }

     
}
