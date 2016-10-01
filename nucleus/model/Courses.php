<?php 

class Courses extends CRUD{

	public function __construct(){
	
	$this->_db = DB::getInstance();	
	
	$this->_table = 'kademiks.courses';
	
	$this->_name = 'Courses';
	
	$this->_title = "Course";
	
	$this->_referencesTo = false;

	$this->_fields = array(
				
						'refid' => array(
						
						'name' => "Department Reference",
						
						'required' => true,
						
						'type' => 'hidden',
						
						'updateAble' => true,
						
						'createAble' => true,
						
							
						),
					
						'course' => array(
							
							'name' => "Course",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 64,
							
							'unique' => $this->_table,
							
							'pattern' => array("%[A-Za-z]{3}\s[0-9]{3}%", "Course Format Is ABC 123"),

							'type' => 'text',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						)
						
						
					);
	
	}
	
}

?>