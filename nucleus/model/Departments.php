<?php 

class Departments extends CRUD{

	public function __construct(){
	
	$this->_db = DB::getInstance();	
	
	$this->_table = 'departments';
	
	$this->_name = 'Departments';
	
	$this->_title = "Department";
	
	$this->_referencesTo = 'courses';

	$this->_fields = array(
				
						'refid' => array(
						
						'name' => "Faculty Reference",
						
						'required' => true,
						
						'type' => 'hidden',
						
						'updateAble' => true,
						
						'createAble' => true,
						
							
						),
					
						'department' => array(
							
							'name' => "Department",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 64,
							
							'unique' => $this->_table,
							

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