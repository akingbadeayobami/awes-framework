<?php 

class Specials extends CRUD{

	public function __construct(){
	
	$this->_db = DB::getInstance();	
	
	$this->_table = Config::get('site/db_prefix') . 'kademiks.specials';
	
	$this->_name = 'Specials';
	
	$this->_title = "Special";
	
	$this->_referencesTo = false;

	$this->_fields = array(
				
						'content' => array(
							
							'name' => "Content",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 5000,
							
							'type' => 'textarea',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
						'category' => array(
							
							'name' => "Category",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 24,
							
							'type' => 'select',
							
							'fields' => 'Riddle,Fact,Joke,Inspiration,Quote,Proverb',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
						'answer' => array(
							
							'name' => "Answer",
							
							'min' => 0,
							
							'max' => 500,

							'type' => 'text',
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
					);
	
	}
	
}

?>