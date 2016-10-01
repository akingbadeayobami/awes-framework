<?php 

class Features extends CRUD{

	public function __construct(){
	
	$this->_db = DB::getInstance();	
	
	$this->_table = Config::get('site/db_prefix') . 'kademiks.features';
	
	$this->_name = 'Features';
	
	$this->_title = "Feature";
	
	$this->_referencesTo = false;

	$this->_fields = array(
				
						'title' => array(
							
							'name' => "Title",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 24,
							
							'unique' => $this->_table,
							
							'type' => 'text',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
						'icon' => array(
							
							'name' => "Icon",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 12,
							
							'type' => 'text',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
						'description' => array(
							
							'name' => "Description",
							
							'required' => true,
							
							'min' => 20,
							
							'max' => 500,
							
							'type' => 'textarea',
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
					);
	
	}
	
}

?>