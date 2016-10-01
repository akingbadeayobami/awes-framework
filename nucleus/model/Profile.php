<?php
class Profile extends ClassInterface{
	
	protected $_table = 'profile';
	
	protected $_validations = 
	
	[
	
		"update" => [ 
	   
		   'lname'=>['name' => 'Last Name', 'required' => true, 'min' => 3, 'max' => 24], 
			
			'fname'=>['name' => 'First Name', 'required' => true, 'min' => 3, 'max' => 24], 
			
			'dname'=>['name' => 'Display Name', 'required' => true, 'min' => 3, 'max' => 24], 
			
			'aboutme'=>['name' => 'About Me', 'required' => true, 'min' => 3],
			
			'hobbies'=>[], 
			
			'dob'=>['name' => 'Date of Birth', 'required' => true], 
			
			'sex'=>['name' => 'Sex', 'required' => true]
			
		 ],
		 
		 "get" => [
		 
			'person' => ['name' => 'Person', 'required' => true, 'type' => 'matric']
		 
		 ],
		 
		 "updatestatus" => [
		 
			'status' => ['name' => 'Status', 'required' => true, 'min' => 3, 'max' => 500]
		 
		 ]
	
	];
	
	public function update(){  
		
		$profile = array('lname' => Input::get('lname'), 'fname' => Input::get('fname'), 'dname' => Input::get('dname'), 'aboutme' => Input::get('aboutme'), 'hobbies' => Input::get('hobbies'), 'birthday' => Input::get('birthday'), 'sex' => Input::get('sex'));

		if($this->_db->update($this->_table, $this->getWhatFromMatric('id'), $profile)){

			$this->_message = 'Profile edited successfully ';
			
			return true;
			
		}else {
			
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
		
		}
		
	}
	
	public function updatePushID(){ 
		
		$pushID = Input::get('pushID');
		
		$fields = array('pushID' => $pushID);

		if($this->_db->update($this->_table, $this->getWhatFromMatric('id'), $fields)){

			$this->_message = 'PushID Updated Successfully';
			
			return true;
			
		}else {
			
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
		
		}
		
	}
	
	public function get(){
		
		$person = Input::get('person');
		
		$data =  $this->_db->get('profile JOIN users ON users.matric = profile.matric', 'users.id, profile.dname, profile.dp, profile.email, profile.lname, profile.fname, users.department, users.matric, users.level, users.faculty, profile.sex, profile.hobbies, profile.birthday, profile.aboutme, profile.status, users.role', '[["users.matric", "=", "' . $person . '"]]');
	
		if($data->count() == 1){
		
			$Course = new Course;
		
			$this->_data = $data->first();
		
			$this->_data->departmentID = $this->_data->department;
			
			$this->_data->facultyID = $this->_data->faculty;
			
			$this->_data->department = $Course->getDepartmentFromId($this->_data->department);
			
			$this->_data->faculty = $Course->getFacultyFromId($this->_data->faculty);
			
			$this->_data->birthdayView = date("j, F", strtotime($this->_data->birthday));
			
			return true;
			
		}
		
		$this->_message = "User Does Not Exists";
		
		return false;
		
	}
	
	public function changeColor($color){
	
		Cookie::put('color',$color,Config::get('cookie/expiry'));
		
		$GLOBALS['config']['site']['color'] = $color;
		
		return true;
		
	}
	
	public function updatestatus(){
		
		$status = Input::get('status');
		
		$fields = array('status' => $status);
		
		$Activities = new Activities;

		if($this->_db->update($this->_table, $this->getWhatFromMatric('id'), $fields) && $Activities->create($status,'status')){

			$this->_message = 'Status Updated Successfully ';
			
			return true;
		
		}else {
			
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
		
		}

	}
	
	public function getWhatFromMatric($what){
	
	$data = $this->_db->get($this->_table, $what, '[["matric", "=", "' . Session::get('matric') . '"]]');
		
		if($data->count() == 1){
			
			$temp = $data->first();
			
			return $temp->$what;
			
		}
		
		return false;
		
	}
	
	public function _getWhatFromMatric($matric,$what){
	
	$data = $this->_db->get($this->_table, $what, '[["matric", "=", "' . $matric . '"]]');
		
		if($data->count() == 1){
			
			$temp = $data->first();
			
			return $temp->$what;
			
		}
		
		return false;
		
	}
	
	public function getObjectFromPersonMatric($person,$field){
	
	$data = $this->_db->get($this->_table, $field, '[["matric", "=", "' . $person . '"]]');
		
		if($data->count() == 1){
			
			$temp = $data->first();
			
			return $temp;
			
		}
		
		return false;
		
	}
	
	public function getObjectFromMatric($field){
	
	$data = $this->_db->get($this->_table, $field, '[["matric", "=", "' . Session::get('matric') . '"]]');
		
		if($data->count() == 1){
			
			$temp = $data->first();
			
			return $temp;
			
		}
		
		return false;
		
	}
	
	public function classmates(){
	
		$User = new User;
	
		$mates = $User->allFromMySet();
		
		if(!$mates){
		
			$this->_message = 'It Seems You Are The Only One In Your Set';
			
			return true;
		
		}
		
		$myMates = Array();
		
		foreach($mates as $temp){
			
			$myMates[] = $temp->matric;
		
		}
		
		$mates = implode(", ", $myMates);
	
		$data = $this->_db->get($this->_table,
		
										'lname, fname, sex,  dname, dp, matric, status', 
										
										'[["matric", "IN", "'.$mates.'"], "ORDER BY matric ASC"]');
		
		if(!$data->error()){
		
			$this->_data = $data->results();
	
			return true;
			
		}
		
		$this->_message = 'An Error Ocurred while processing your request';
		
		return false;
		
	}

	public function changeDP(){

		if (!empty($_FILES)){
		
			$fileField = 'file';

			$fileName = $_FILES[$fileField]["name"];
							
			$fileType = $_FILES[$fileField]["type"];
			
			$fileSize = $_FILES[$fileField]["size"];

			$uploadDirectory = 'assets/images/avatars/' . Config::get('mysql/db') . '/';
			
			$tempLocation = $_FILES[$fileField]["tmp_name"];
			
			if (($fileType != "image/jpeg") && ($fileType != "image/png") && ($fileType != "image/gif")){ 
				
				$this->_message = "Invalid File" ; 
				
				return	false;
						
			}
			
			$fileName = md5($fileName.Session::get('matric')); 

			switch($fileType){ case "image/jpeg":  $fileName = $fileName.'.jpg'; break; case "image/png": $fileName = $fileName.'.png'; break; case "image/gif": $fileName = $fileName.'.gif'; break; }
			
			if ( $fileSize > 2097152 ) { 	

				$this->_message = "File Too Large" ; 
				
				return	false;
						
			}
			
			$UD = dirname( __FILE__ ) .  "../../../$uploadDirectory";
			
			if (!file_exists($UD)){
			  
				 mkdir($UD, 0777, true);
		 
			}
			
			$fileLocation = $UD.$fileName; 
			
			$dp = $uploadDirectory.$fileName;
			
			
			if (file_exists($fileLocation)) {

				$this->_message = "It Seems You Have Uploaded This File Before. If You Insist Using It Please Try Renaming It" ; 
				
				return true;
				
			}
			
			move_uploaded_file($tempLocation,$fileLocation);
			
			$data = array('dp' => $dp);
			
			$Activities = new Activities;

			if($this->_db->update($this->_table, $this->getWhatFromMatric('id'), $data) && $Activities->create($dp,'dp')){
				
				$this->_data = $dp;
				
				$this->_message = "Profile Picture Updated Successfully" ; 
				
				return true;
			
			}
				
			$this->_message = "An Error Occurred Please Try Again" ; 
			
			return	false;
						
		}	

	} 

}

?>