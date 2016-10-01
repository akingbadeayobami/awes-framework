<?php 
// Updating eish, validation
class Blog extends CRUD{

	public function __construct(){
	
	$this->_db = DB::getInstance();	
	
	$this->_table = 'blog';
	
	$this->_name = 'Blog';
	
	$this->_title = "Blog Post";
	
	$this->_fields = array(
					
						'title' => array(
							
							'name' => "Title",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 20,
							
							'unique' => $this->_table,
							

							'type' => 'text',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
							
						),
						
						'tag' => array(
						
							'name' => "Tag",
							
							'required' => true,
							
							'min' => 2,
							
							
							
							'type' => 'select',
							
							'fields' => 'male,female,negative', // $this->getSelectFieldFromDb('table','field'),
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
							
						),
							
						'image' => array(
						
							'name' => "Picture",
							
							'required' => true,
							
							'type' => 'file',
							
							'directory' => 'assets/images/blog/',
							
							'updateAble' => true,
							
							'createAble' => true
						
						),
						
						'content' => array(
							
							'name' => "Content",
							
							'min' => 2,
							
							'max' => 200,
							
							'required' => true,
							
							
							'type' => 'textarea',
							
							'viewAble' => true,
							
							'updateAble' => true,
							
							'createAble' => true,
							
							'searchAble' => true
								
						)
						
					);
	
}

}
?>