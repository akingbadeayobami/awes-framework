<?php
class Messages extends ClassInterface{
	
	protected $_table = 'messages';
	
	public function send(){
		
		$receiver = Input::get('receiver');
		
		$message = Input::get('message');
		
		$fields = array(		
			
			'sender' => Session::get('matric'),
			
			'receiver' => $receiver,
			
			'message' => $message,
			
			'opened' => 'no',

			'time' => time()

		);

		if(!$this->_db->insert($this->_table, $fields)){
		
			$this->_message = 'An Error Ocurred while processing your request';
		
			return false;
		
		}
		
		$Profile = new Profile;
		
		$dname = $Profile->getWhatFromMatric('dname');
		
		$Notification = new Notification;
		
		$Notification->create("$dname sent you a new message",$receiver,"message",'null');
		
		$this->_message = 'Message Sent Successfully';
		
		return true;
		
	}
	
	public function getThread (){
		
		$person = Input::get('person');
		
		$page = (Input::get('page')) ? Input::get('page') : 1;
		
		$this->_data = $this->getPersonThread($person,$page);
		
		if($this->_data === false){
		
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
		
		}
		
		return true;
	
	}
	
	public function getPersonThread($person,$page = 1){ 
	
		$page--;

		$limit = 'LIMIT '. $page * 10 .','. 10;
			
		$data = $this->_db->get($this->_table, '*', '[ "(", ["sender", "=", "'.Session::get('matric').'"], "AND", ["receiver", "=", "'.$person.'"], ")", "OR", "(", ["sender", "=", "'.$person.'"], "AND", ["receiver", "=", "'.Session::get('matric').'"], ")", "ORDER BY id DESC '. $limit. '"]');
		
		if(!$data->error()){
		
			return $data->results();
			
		}
		
		return false;
		
	}
	
	public function getMyMessages(){
	
		$data = $this->_db->get($this->_table, 'DISTINCT sender, receiver', '[ ["sender", "=", "'.Session::get('matric').'"], "OR", ["receiver", "=", "'.Session::get('matric').'"] ]');
		
		$results = $data->results();
		
		$persons = array();
		
		foreach ($results as $temp){
		
			$persons[] = $temp->sender;
			
			$persons[] = $temp->receiver;
		
		}
		
		$persons = array_unique($persons);
		
		$persons = array_diff($persons, array(Session::get('matric')));
		
		$Profile = new Profile;
		
		foreach($persons as $person){
		
			$temp = $Profile->getObjectFromPersonMatric($person, 'dname,dp,sex');
			
			$temp->matric = $person;
			
			$temp->messages = $this->getPersonThread($person,1);
			
			$allMessages[] = $temp;
		
		}
	
		$this->_data = $allMessages;
		
		return true;
		
	}
	
	public function readMessage(){
		
		$person = Input::get('person');
		
		$data = $this->_db->get($this->_table, 'id', '[["sender", "=", "' . $person . '"], "AND", ["opened", "=", "no"] , "AND", ["receiver", "=", "' . Session::get('matric') . '"]]');
		
		$settings = array('opened' => 'yes');
		
		foreach($data->results() as $temp){
		
			if(!$this->_db->update($this->_table, $temp->id, $settings)){
		
				$this->_message = 'An Error Ocurred while processing your request';
				
				return false;
			
			}
		
		}
		
		return true;
		
	}
	
}

?>