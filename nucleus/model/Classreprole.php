<?php
class Classreprole extends ClassInterface{
	
	protected $_table = 'users';
	
	public function drop(){
	
		$fields = array('role' => '1');
		
		$Profile = new Profile;

		if($this->_db->update($this->_table, $Profile->getWhatFromMatric('id'), $fields)){

			$this->_message = 'Class Rep Role Dropped Succesfully';
			
			return true;
			
		}else {
			
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
		
		}
		
	}
	
	public function manage(){
	
		$User = new User;
		
		$temp = $User->getObjectFromMatric('level,department,role');
		
		$department = $temp->department;
		
		$level = $temp->level;
		
		$role = $temp->role;
		
		$data = $this->_db->get('profile JOIN users ON profile.matric = users.matric', 'profile.matric , profile.dname,  profile.fname,  profile.lname, profile.sex, profile.dp, profile.status, users.department, users.level', '[["users.department", "=", "' . $department . '"], "AND", ["users.level", "=", "' . $level . '"], "AND", ["users.role", "=", "2"]]');
		
		if(!$data->error()){
			
			$this->_data = $data->results();
			
			return true;
			
		}
		
		$this->_message = 'An Error Ocurred while processing your request';
		
		return false;
		
	}
	
	public function take(){ 

		$User = new User;
		
		$Object = $User->getObjectFromMatric('level,department,id,role');
		
		if($Object->role == '2'){
		
			$this->_message = 'You Already Have The Class Rep Role';
		
			return true;
		
		}
	
		$data = $this->_db->get($this->_table, '1', '[["department", "=", "' . $Object->department . '"], "AND", ["level", "=", "' . $Object->level . '"], "AND", ["role", "=", "2"]]');
		
		if($data->count() >= 3){
			
			$this->_message = "Your Class Already Has Three Classrep";
			
			return false;
			
		}
		
		$fields = array('role' => '2');
		
		if($this->_db->update($this->_table, $Object->id, $fields)){

			$this->_message = 'Class Rep Role Taken Succesfully';
			
			return true;
			
		}
	
		$this->_message = 'An Error Ocurred while processing your request';
			
		return false;
		
	}

}

?>