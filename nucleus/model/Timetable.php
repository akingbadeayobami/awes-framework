<?php
class Timetable extends ClassInterface{
	
	protected $_table = 'timetable';
	
	protected $_validations = 
	
	[
	
		"add" => [ 
	   
		   'course'=>['name' => 'Course', 'required' => true], 
			
			'day'=>['name' => 'Day', 'required' => true], 
			
			'timeFrom'=>['name' => 'Time From', 'required' => true, 'type' => "time"], 
			
			'timeTo'=>['name' => 'Time To', 'required' => true, 'type' => "time"],
			
			'venue'=>['name' => 'Venue', 'max' => 24], 
			
			'lecturer'=>['name' => 'lecturer', 'max' => 24], 
			
		 ],
		 
		 "remove" => [
		 
			'id' => ['name' => 'ID', 'required' => true, 'type' => 'number']
		 
		 ]
		 
	
	];
	
	public function add(){ 
		
		$course = Input::get('course');
		
		$day = Input::get('day');
		
		$timefrom = Input::get('timefrom');
		
		$timeto = Input::get('timeto');
		
		$venue = Input::get('venue');
		
		$lecturer = Input::get('lecturer');
		
		$Course = new Course;
		
		if(!preg_match("%[A-Za-z]{3}\s[0-9]{3}%",$course) || !$Course->isCourseValid($course)){
		
			$this->_message = "Course Seems To Be Invalid";
	
			return false;
			
		}
		
		$fields = array(		

			'course' => $course,

			'day' => $day,

			'timefrom' => $timefrom,

			'timeto' => $timeto,

			'venue' => $venue,
			
			'lecturer' => $lecturer
			
		 );
		 
		 $insert = $this->_db->insert($this->_table, $fields);

		if(!$insert){
		
			$this->_message = 'An Error Ocurred while processing your request';
		
			return false;
		
		}
		
		$Notification = new Notification;
		
		$Notification->create("$course has been added to timetable ",'null',"timetable",$course);
		
		$data = $this->_db->get($this->_table, 'id', '["1", "ORDER BY id DESC LIMIT 1"]');
		
		$this->_data = $data->first()->id;
		
		$this->_message = "Course Added From Timetable Successfully";
			
		return true;
		
	}
	
	public function remove(){ 
	
		$id = Input::get('id');
			
		$data = $this->_db->get($this->_table, 'course', '[["id", "=", "'.$id.'"]]');
		
		if($data->count() != 1){
		
			$this->_message = 'Course Removed From Timetable Successfully';
		
			return true;
		
		}
		
		$course = $data->first()->course;
	
		if(!$this->_db->delete($this->_table, $id)){
		
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
			
		}
		
		$Notification = new Notification;
		
		$Notification->create("$course has been removed from timetable",'null',"timetable",$course);
		
		$this->_message = "Course Removed From Timetable Successfully";
		
		return true;
		
	}

	public function get(){
	
	$Course = new Course;
	
	$Course->my();
	
	$myCourses = $Course->data();
	
	if(sizeof($myCourses) == 0){
	
		$this->_message = "You Have Not Registered Any Course yet";
		
		return false;
	
	}
	
	$courses = Array();
	
	foreach ($myCourses as $course){
	
		$courses[] = $course->course;
	
	}
	
	 $courses = implode(", ", $courses);
	
	$data = $this->_db->get($this->_table, '*', '[["course", "IN", "' . $courses . '"], "ORDER BY timefrom"]');
		
		if(!$data->error()){
			
			$this->_data = $data->results();
			
			return true;
			
		}
		
		return false;
		
	}

}
?>