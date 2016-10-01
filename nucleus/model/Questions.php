<?php 

class Questions extends CRUD{

	public function __construct(){
	
	$this->_db = DB::getInstance();	
	
	$this->_table = Config::get('site/db_prefix') . 'kademiks.questions';
	
	$this->_name = 'Questions';
	
	$this->_title = "Question";
	
	$this->_referencesTo = false;

	$this->_fields = array(
				
						'course' => array(
							
							'name' => "Course",
							
							'required' => true,
							
							'type' => 'text',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
						),
						
						
						'question' => array(
							
							'name' => "Question",
							
							'required' => true,
							
							'min' => 12,
							
							'max' => 500,
							
							'type' => 'textarea',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
						),
						
						'option1' => array(
							
							'name' => "Option A",
							
							'required' => true,
							
							'type' => 'text',
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
						),
						
						'option2' => array(
							
							'name' => "Option B",
							
							'required' => true,
							
							'type' => 'text',
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
						),
						
						'option3' => array(
							
							'name' => "Option C",
							
							'required' => true,
							
							'type' => 'text',
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
						),
						
						'option4' => array(
							
							'name' => "Option D",
							
							'required' => true,
							
							'type' => 'text',
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
						),
							
						'answer' => array(
							
							'name' => "Answer",
							
							'required' => true,
							
							'type' => 'select',
							
							'fields' => 'A,B,C,D',
							
							'updateAble' => true,
							
							'createAble' => true,
							
						),
						
						'setby' => array(
							
							'name' => "Set By",
							
							'required' => true,
							
							'type' => 'hidden',
							
							'value' => Session::get('matric'),
							
							'createAble' => true,
							
						),
						
					);
	
	}
	
}

?>