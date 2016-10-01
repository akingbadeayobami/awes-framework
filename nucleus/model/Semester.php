<?php
class Semester extends ClassInterface{
	
	protected $_table = 'semesters';
	
	public function add(){
	
		$semester = Input::get('semester');

		$data = $this->_db->get( $this->_table, '1', '[["semester", "=", "'.$semester.'"], "AND", ["person", "=", "'.Session::get('matric').'"]]');
		
		if($data->count() == 1){
		
			$this->_message = "Semester Already Added";
	
			return true;
			
		}
		
		$fields = array(		

			'person' => Session::get('matric'),

			'semester' => $semester

		 );
		 
		 $insert = $this->_db->insert($this->_table,  $fields);

		if(!$insert){
		
			$this->_message = 'An Error Ocurred while processing your request';
		
			return false;
		
		}
		
		$data = $this->_db->get($this->_table, 'id', '["1 ORDER BY id DESC LIMIT 1"]');
		
		$this->_data = $data->first()->id;
		
		$this->_message = "Semester Added Successfully";
			
		return true;
		
	}
	
	public function remove(){ 
	
		$id = Input::get('id');
	
		if(!$this->_db->delete($this->_table, $id) || !$this->_db->deleteSpecial('grades', 'semester', $id) ){
		
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
			
		}
		
		$this->_message = "Semester Removed Successfully";
		
		return true;
		
	}

}
?>