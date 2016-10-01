<?php 

class Faculties extends CRUD{

	public function __construct(){
	
		$this->_db = DB::getInstance();	
		
		$this->_table = 'faculties';
		
		$this->_name = 'Faculties';
		
		$this->_title = "Faculty";
		
		$this->_referencesTo = 'departments';

		$this->_fields = array(
					
							'faculty' => array(
								
								'name' => "Faculty",
								
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
