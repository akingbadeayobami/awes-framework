<?php
class Activities extends ClassInterface{
	
	protected $_table = 'activities';

	public function create($activity,$type){
	
		$fields = array(		
			
			'person' => Session::get('matric'),
			
			'activity' => $activity,
			
			'type' => $type,

			'time' => time()

		);

		if(!$this->_db->insert($this->_table, $fields)){
		
			return false;
		
		}
		
		return true;
		
	}
	
	public function like(){ 
		
		$id = Input::get('id');
		
		$data = $this->_db->get('activitieslikes', '1', '[["person", "=", "'.Session::get('matric').'"], "AND", ["actid", "=", "'.$id.'"], "LIMIT 1"]');
		
		if($data->count() == 1){
		
			$this->_message = 'Already Liked';
		
			return true;
		
		}
		
		
		$fields = array(

			'actid' => $id,
				
			'person' => Session::get('matric')
					
		);
		
		if($this->_db->insert('activitieslikes', $fields)){
		
			return true;
		
		}
		
		$this->_message = 'An Error Ocurred while processing your request';
			
		return false;
		
	}
	
	public function specialslike(){ 
	
		$id = Input::get('id');
		
		$data = $this->_db->get( Config::get('site/db_prefix') . 'kademiks.specialslikes', '1', '[["person", "=", "'.Session::get('matric').'"], "AND", ["refid", "=", "'.$id.'"], "LIMIT 1"]');
		
		if($data->count() == 1){
		
			$this->_message = 'Already Liked';
		
			return true;
		
		}
		
		$fields = array(

			'refid' => $id,
				
			'person' => Session::get('matric')
					
		);
		
		if($this->_db->insert( Config::get('site/db_prefix') . 'kademiks.specialslikes', $fields)){
			
			return true;
		
		}
		
		$this->_message = 'An Error Ocurred while processing your request';
			
		return false;
		
	}
	
	public function mine(){ 
		
		$person = Input::get('person');
		
		$page = (Input::get('page')) ? Input::get('page') : 1;
		
		$page--;

		$limit = 'LIMIT '. $page * 20 .','. 20;
			
		$data = $this->_db->get($this->_table, '*', '[["person", "=", "'.$person.'"], "ORDER BY time DESC '. $limit. '"]');
		
		$this->_data = Array();
		
		if(!$data->error()){
		
			foreach( $data->results() as $temp){
			
				$data = $this->_db->get('activitieslikes', 'COUNT(*) AS num', '[["actid", "=", "' . $temp->id . '"]]');
				
				$temp->likes = $data->first()->num;
				
				$this->_data[] = $temp;
					
			}
					
			return true;
			
		}
		
		$this->_message = 'An Error Ocurred while processing your request';
			
		return false;
		
	}
	
	public function get(){ 
		
		$wide = (Input::get('wide')) ? Input::get('wide') : 'set';
		
		$page = (Input::get('page')) ? Input::get('page') : 1;
		
		$User = new User;
			
		switch($wide){
		
			case 'set' :
			
				$mates = $User->allFromMySet();
			
			break;
		
			case 'department' :
			
				$mates = $User->allFromMyDepartment(Session::get('matric'));
			
			break;
		
			case 'faculty' :
			
				$mates = $User->allFromMyFaculty(Session::get('matric'));
			
			break;
			
			case 'university' :
		
				$mates = $User->everyBody();
			
			break;
			
			case 'specials' :
		
				$this->_data = $this->specials(20);
				
				$Adverts = new Adverts();	
				
				$rawAdvert = $Adverts->serve();
				
				if($rawAdvert){
				
					$rawAdvert->type = 'revenue';
					
					array_push($this->_data,$rawAdvert);
				
				}
				
				return true;
			
			break;
			
			default :
			
				$mates = $User->allFromMySet();
				
		}
		
		if(!$mates){
		
			$this->_message = 'It Seems You Are The Only One in your ' . $wide;
			
			return true;
		
		}
		
		$myMates = Array();
		
		foreach($mates as $temp){
			
			$myMates[] = $temp->matric;
		
		}
		
		// $myMates[] = Session::get('matric');
		
		$mates = implode(", ", $myMates);
	
		$page--;

		$limit = 'LIMIT '. $page * 20 .','. 20;
			
		$data = $this->_db->get('activities JOIN profile ON activities.person = profile.matric', 
		
										'profile.dname, profile.dp, profile.sex, activities.id,  activities.person, activities.type, activities.time, activities.activity', 
										
										'[["activities.person", "IN", "'.$mates.'"], "ORDER BY activities.time DESC '. $limit. '"]');
		
		$this->_data = Array();
		
		if(!$data->error()){
		
			foreach( $data->results() as $temp){
			
				$data1 = $this->_db->get('activitieslikes', 'COUNT(*) AS num', '[["actid", "=", "' . $temp->id . '"]]');
				
				$temp->likes = $data1->first()->num;
				
				$this->_data[] = $temp;
					
			}
			
			if($data->count() > 0){
			
				$this->_data = array_merge($this->_data,$this->specials(1));
				
				$Adverts = new Adverts();	
				
				$rawAdvert = $Adverts->serve();
				
				if($rawAdvert){
				
					$rawAdvert->type = 'revenue';
					
					array_push($this->_data,$rawAdvert);
				
				}
				
			
			}
					
			return true;
			
		}
		
		$this->_message = 'An Error Ocurred while processing your request';
			
		return false;
		
	}

	public function specials($length){ 
	
		$data = $this->_db->get( Config::get('site/db_prefix') . 'kademiks.specials', '*', '[" 1 ORDER BY RAND() LIMIT '.$length.'"]');
		
		$this->_data = Array();
		
		if(!$data->error()){
		
			foreach( $data->results() as $temp){
			
				$data1 = $this->_db->get( Config::get('site/db_prefix') . 'kademiks.specialslikes', 'COUNT(*) AS num', '[["refid", "=", "' . $temp->id . '"]]');
				
				$temp->likes = $data1->first()->num;
				
				$temp->dname = Config::get('site/name');
				
				$temp->dp = 'assets/images/avatars/defaultlogo.png';
				
				$temp->person = '#';
				
				$temp->type = 'specials';
				
				$_data[] = $temp;
					
			}
			
			return $_data;
			
		}
		
		$this->_message = 'An Error Ocurred while processing your request';
			
		return false;
		
	}

}

?>