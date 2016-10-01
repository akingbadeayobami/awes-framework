<?php
class Contact extends ClassInterface{
	
	public function __construct(){
	
		$this->_table = Config::get('site/db_prefix') . 'kademiks.contactmessage';
	
	}
	
	protected $_validations = 
	
	[
	
		"admin" => [ 
	   
		   'name'=>['name' => 'Name', 'required' => true, 'min' => 3, 'max' => 24], 
			
			'email'=>['name' => 'Email', 'required' => true, 'min' => 3, 'max' => 24, 'type' => 'email'], 
			
			'message'=>['name' => 'Message', 'required' => true, 'min' => 3, 'max' => 250], 
			
			'subject'=>['name' => 'Subject', 'required' => true, 'min' => 3, 'max' => 32],
			
			'type'=>['name' => 'Type', 'required' => true]
			
		 ],

		 "us" => [ 
	   
		   'name'=>['name' => 'Name', 'required' => true, 'min' => 3, 'max' => 24], 
			
			'email'=>['name' => 'Email', 'required' => true, 'min' => 3, 'max' => 24, 'type' => 'email'], 
			
			'message'=>['name' => 'Message', 'required' => true, 'min' => 3, 'max' => 250], 
			
			'subject'=>['name' => 'Subject', 'required' => true, 'min' => 3, 'max' => 100]
			
		 ]
		 
	];
	
	
	
	public function Admin(){
		
		$name = Input::get('name');
		
		$email = Input::get('email');
		
		$message = Input::get('message');
		
		$subject = Input::get('subject');
		
		$type = Input::get('type');
		
		$fields = array(		
			
			'name' => $name,
				
			'email' => $email,
			
			'message' => $message,
			
			'subject' => $subject,
			
			'type' => $type,
			
			'time' => time(),
			
			'addressed' => 'no',
			
			'matric'=> (Session::exists('matric')) ? Session::get('matric') : "000000000",
			
			'reply'=> ''

		);

		if(!$this->_db->insert($this->_table, $fields)){
		
			$this->_message = 'An Error Ocurred while processing your request';
		
			return false;
		
		}
		
		Mail::send(Config::get('site/contactMail'),$type . " - " . $subject,$message);
		
		$this->_message = 'Message Sent Successfully';
		
		return true;
		
	}
	
	public function Us(){
		
		$name = Input::get('name');
		
		$email = Input::get('email');
		
		$message = Input::get('message');
		
		$subject = Input::get('subject');
		
		$this->Admin($name,$email,$message,$subject,"Contact Us");
		
		$message = 'Name : ' .  $name . '<br />' ;
	
		$message .=  'Email : ' .  $email .  '<br />' ;
		
		$message .=  'Message : ' .$message .  '<br />' ;
		
		$mailSent = Mail::send(Config::get('site/contactMail') ,Config::get('site/name') . " Contact Messages - " . $subject , $message);
	
		if($mailSent){
			
			$this->_message = "Your Message Has Been Sent Successfully";
			
			return true;
			
		}
		
		$this->_message  = "An Error Ocurred While Processing Your Request. Please Try Again";
		
		return false;
	
			
	}
	

}

?>