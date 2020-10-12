<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Conversation;

class DataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {        
		User::truncate();	  
		Conversation::truncate();	  
        
        $usuarios = [
            [	    	
	    		'id' => 1, 	    		
				'name' => 'User1',   
				'email' => 'user1@gmail.com',   
				'password' => '123456',   				    		
	    	],
            [	    
				'id' => 2, 		    		 
				'name' => 'User2',   
				'email' => 'user2@gmail.com',   
				'password' => '123456',   				
	    	],	    	
	    ];

	    foreach($usuarios as $usuario){
		    User::create($usuario);
		}

		$conversaciones = [
            [	    		    		
	    		'user1Id' => $usuarios[0]['id'],   
				'user2Id' => $usuarios[1]['id'], 				    		
	    	],              	
	    ];

	    foreach($conversaciones as $conversacion){
		    Conversation::create($conversacion);
		}
    }
}
