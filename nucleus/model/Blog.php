<?php 
// Updating eish, validation
class Blog extends CRUD{
	
	protected $_table = 'blog';
	
	protected $_name = 'Blog';
	
	protected $_title = "Blog Post";
	
	protected $_fields = array(
					
						'title' => array(
							
							'name' => "Title",
							
							'required' => true,
							
							'min' => 2,
							
							'max' => 20,
							
							'unique' => 'blog',
							

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
							
							'fields' => 'male,female,negative',
							
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

?>