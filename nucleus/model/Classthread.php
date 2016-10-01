<?php
class Classthread extends ClassInterface{
	
	protected $_table = 'classthread';
	
	protected $_validations = 

			[
			
				"post" => [ 
				   
					'message'=>['name' => 'Message', 'required' => true, 'min' => 3, 'max' => 500]
					
				],
				
			];


	
	public function post(){
	
		$message = Input::get('message');
		
		$User = new User;
		
		$Object = $User->getObjectFromMatric('level,department');

		$fields = array(		
			
			'level' => $Object->level,
			
			'department' => $Object->department,
			
			'message' => $message,
			
			'person' => Session::get('matric'),

			'time' => time()

		);

		if(!$this->_db->insert($this->_table, $fields)){
		
			$this->_message = 'An Error Ocurred while processing your request';
		
			return false;
		
		}
		
		$Profile = new Profile;
		
		$dname = $Profile->getWhatFromMatric('dname');
		
		$Notification = new Notification;
		
		$Notification->create("$dname posted a new message on your class thread",'null',"classthread",'null');
		
		$this->_message = 'Message Posted Successfully';
		
		return true;
		
	}
	
	public function get(){ 
		
		$page = (Input::get('page')) ? Input::get('page') : 1;
		
		$User = new User;
		
		$Object = $User->getObjectFromMatric('level,department');

		$page--;

		$limit = 'LIMIT '. $page * 20 .','. 20;
			
		$data = $this->_db->get('classthread JOIN profile ON classthread.person = profile.matric', 
		
										'profile.matric, profile.dname, profile.sex,  profile.dp, classthread.message, classthread.time', 
										
										'[["classthread.level", "=", "'.$Object->level.'"], "AND", ["classthread.department", "=", "'.$Object->department.'"], "ORDER BY classthread.id DESC '. $limit. '"]');

		if(!$data->error()){
			
			$threads = Array();
			
			foreach($data->results() as $temp){
			
				$temp->type = 'thread';
			
				$threads[] = $temp;
				
			}
			
			if(count($threads) > 4 ){ // && $page % 3 = 0
			
				$Adverts = new Adverts();	
			
				$rawAdvert = $Adverts->serve();
				
				if($rawAdvert){
				
					$rawAdvert->type = 'revenue';
					
					array_push($threads,$rawAdvert);
				
				}
			
			}
		
			$this->_data = $threads;
					
			return true;
			
		}
		
		$this->_message = 'An Error Ocurred while processing your request';
			
		return false;
		
	}

}

?>