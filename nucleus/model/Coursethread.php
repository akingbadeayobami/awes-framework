<?php
class Coursethread extends ClassInterface{
	
	protected $_table = 'coursethread';
	
	public function post(){
		
		$courseid = Input::get('courseid');
		
		$message = Input::get('message');
		
		$Course = new Course;
	
		$course = $Course->getCourseFromID($courseid);
		
		if(!$course){
		
			$this->_message = 'It Seems You are posting to a non existing course';
		
			return false;
		
		}
		
		$fields = array(		
			
			'courseid' => $courseid,
			
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
		
		$Notification->create("$dname posted a new message on $course ","$courseid","coursethread","$course");

		return true;
		
	}
	
	public function get(){ 
		
		$courseid = Input::get('courseid');
		
		$page = (Input::get('page')) ? Input::get('page') : 1;
		
		$page--;

		$limit = 'LIMIT '. $page * 20 .','. 20;
			
		$data = $this->_db->get('coursethread JOIN profile ON coursethread.person = profile.matric', 
		
										'profile.matric, profile.dname, profile.sex,  profile.dp, coursethread.message, coursethread.time, coursethread.id', 
										
										'[["coursethread.courseid", "=", "'.$courseid.'"], "ORDER BY coursethread.id DESC '. $limit. '"]');

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