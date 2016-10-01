<?php
class Grade extends ClassInterface{
	
	protected $_table = 'grades';

	public function add(){
		
		$course = Input::get('course');
		
		$unit = Input::get('unit');
		
		$grade = Input::get('grade');
		
		$semesterid = Input::get('semesterid');
		
		$data = $this->_db->get('semesters', '1', '[["id", "=", "'.$semesterid.'"]]');
		
		if($data->count() == 0){
		
			$this->_message = "The Semester You Are Tryng To Add To Doesn't Exixt";
	
			return true;
			
		}
		
		$fields = array(		

			'person' => Session::get('matric'),

			"course" => $course,
			
			"unit" => $unit,
			
			"grade" => $grade,
			
			"semester" => $semesterid

		 );
		 
		 $insert = $this->_db->insert($this->_table, $fields);

		if(!$insert){
		
			$this->_message = 'An Error Ocurred while processing your request';
		
			return false;
		
		}
		
		$data = $this->_db->get($this->_table, 'id', '["1 ORDER BY id DESC LIMIT 1"]');
		
		$this->_data = $data->first()->id;
		
		$this->_message = "Grade Added Successfully";
			
		return true;
		
	}
	
	public function remove(){ 
		
		$id = Input::get('id');
		
		if(!$this->_db->delete($this->_table, $id)){
		
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
			
		}
		
		$this->_message = "Grade Removed Successfully";
		
		return true;
		
	}

	public function get(){

		$data = $this->_db->get('semesters', 'id,semester', '[["person", "=", "' . Session::get('matric') . '"], "ORDER BY semester"]');
		
		if($data->count() == 0){
			
			$this->_message = "It Seems You Haven't Added Any Data";
			
			return true;
			
		}
		
		foreach($data->results() as $temp){
		
			$data1 = $this->_db->get($this->_table, '*', '[["semester", "=", "' . $temp->id . '"], "ORDER BY course"]');
			
			$temp->grades = $data1->results();
			
			$this->_data[] = $temp;
			
		}
		
		return true;
		
	}

}
?>