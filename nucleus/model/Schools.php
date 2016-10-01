<?php 

class Schools extends CRUD{

	public function __construct(){
	
	$this->_db = DB::getInstance();	
	
	$this->_table = Config::get('site/db_prefix') . 'kademiks.schools';
	
	$this->_name = 'Schools';
	
	$this->_title = "School";
	
	$this->_referencesTo = false;

	$this->_fields = array(
				
						'name' => array(
							
							'name' => "Name",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 64,
							
							'unique' => $this->_table,
							

							'type' => 'text',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
						'url' => array(
							
							'name' => "Url",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 16,
							
							'type' => 'text',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
						'slogan' => array(
							
							'name' => "Slogan",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 32,

							'type' => 'text',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
					);
	
	}
	
}

?>