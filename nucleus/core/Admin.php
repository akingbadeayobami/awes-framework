<?php
class CRUD{
	
	protected $_db, $_data = Array(), $_validations = Array(),  $_table, $_title, $_message, $_name, $_fields;

	public function __construct(){

		$this->_db = DB::getInstance();	
	
	}

	public function create(){ 

					$fileFields = Neutron::getFromFieldThisThat($this->_fields, 'type', 'file');
					
					foreach ($fileFields as $fileField ){
						
						if ($_FILES[$fileField]["size"] != 0){
							
							$_POST[$fileField] = true;
				
						}
						
					} 
					
					foreach ($fileFields as $fileField ){
						
						$fileName = $_FILES[$fileField]["name"];
						
						$fileType = $_FILES[$fileField]["type"];
						
						$fileSize = $_FILES[$fileField]["size"];

						$uploadDirectory = $this->_fields[$fileField]['directory'];
						
						$tempLocation = $_FILES[$fileField]["tmp_name"];
						
						if (($fileType != "image/jpeg") && ($fileType != "image/png") && ($fileType != "image/gif")){ 
							
							Session::flash('error',"File Type Not Supported"); return false; 
							
						}
						
						$fileName = md5($fileName); 

						switch($fileType){ case "image/jpeg":  $fileName = $fileName.'.jpg'; break; case "image/png": $fileName = $fileName.'.png'; break; case "image/gif": $fileName = $fileName.'.gif'; break; }
						
						if ( $fileSize > 1048576 ) { 	Session::flash('error',"File Too Large"); return false; }
						
						$UD = dirname( __FILE__ ) .  "../../../$uploadDirectory";
						
						if (!file_exists($UD)){
						  
							mkdir($UD, 0777, true);
					 
						}
						
						$fileLocation = $UD.$fileName; 
						
						if (!file_exists($fileLocation)) {
			
							move_uploaded_file($tempLocation,$fileLocation);
							
							$_POST[$fileField] = $uploadDirectory.$fileName;
						
						}
						
					}
					
					$createAbles = Neutron::getFromField( $this->_fields , 'createAble');
					
					$fields = array();
					
					foreach($createAbles as $props){
						
						$temp = array($props => Input::get($props));
						
						$fields = array_merge($fields, $temp);
						
					}
					
					$fields = array_merge($fields,  array( 'created' => time() ));
					
					$fields = array_merge($fields,  array( 'updated' => time() ));
					
					if($this->_db->insert($this->_table, $fields)){
			
						$this->_message = $this->_title . ' Added Successfully ';
						
						return true;
						
					}else {
						
						$this->_message  = 'An Error Ocurred while processing your request';
						
						return false;
						
					
					}
					
				}
				
			}
				
		}
		
	}
	
	public function update(){ 

		
					$fileFields = Neutron::getFromFieldThisThat($this->_fields, 'type', 'file');
					
					foreach ($fileFields as $fileField ){
						
						if ($_FILES[$fileField]["size"] != 0){
							
							$_POST[$fileField] = true; // 
				
						}
						
					} 
		
					foreach ($fileFields as $fileField ){
						
						$fileName = $_FILES[$fileField]["name"];
						
						$fileType = $_FILES[$fileField]["type"];
						
						$fileSize = $_FILES[$fileField]["size"];

						$uploadDirectory = $this->_fields[$fileField]['directory'];
						
						$tempLocation = $_FILES[$fileField]["tmp_name"];
						
						if (($fileType != "image/jpeg") && ($fileType != "image/png") && ($fileType != "image/gif")){ 
							
							Session::flash('error',"File Type Not Supported"); return false; 
							
						}
						
						$fileName = md5($fileName); 

						switch($fileType){ case "image/jpeg":  $fileName = $fileName.'.jpg'; break; case "image/png": $fileName = $fileName.'.png'; break; case "image/gif": $fileName = $fileName.'.gif'; break; }
						
						if ( $fileSize > 1048576 ) { 	Session::flash('error',"File Too Large"); return false; }
						
						$UD = "../$uploadDirectory";
						
						if (!file_exists($UD)){
						   
							mkdir($UD, 0777, true);
					 
						}
						
						$fileLocation = $UD.$fileName; 
						
						if (!file_exists($fileLocation))  {
			
							move_uploaded_file($tempLocation,$fileLocation);
							
							$_POST[$fileField] = $uploadDirectory.$fileName;
						
						}
						
					}
					
					foreach ($fileFields as $fileField ){
						
						if ($_POST[$fileField] == true){
							
							$_POST[$fileField] = $_POST['prev'.$fileField]; 
				
						}
						
					} 
					
							
					$fields = array();
					
					$updateAbles = Neutron::getFromField( $this->_fields , 'updateAble');
					
					foreach($updateAbles as $props){
						
						$temp = array($props => Input::get($props));
						
						$fields = array_merge($fields, $temp);
						
					}
					
					$fields = array_merge($fields,  array( 'updated' => time() ));
						
					if($this->_db->update($this->_table, Input::get('thisID'), $fields)){
			
						Session::flash('success', $this->_title . ' edited successfully ');
						
						return true;
						
					}else {
						
						Session::flash('error','An Error Ocurred while processing your request');
						
						return false;
					
					}
					
				}
				
			}
				
		}
		
	}
	
	public function delete(){ 

		if($this->_db->delete($this->_table, Input::get('delete'))){
				
							Session::flash('success', $this->_title . ' deleted successfully ');
							
							return true;
							
						}else {
							
							Session::flash('error','An Error Ocurred while processing your request');
							
							return false;
							
						
						}
					
				}
				
			}
				
		}
		
	}
	
	public function read(){ 
	
		$where = (Input::get('refid')) ? '["refid", "=", "' . Input::get('refid'). '"]'  : '["1", "=", "1"]';
	
		$data = $this->_db->get($this->_table, '*', '[' . $where. ']');
		
		if($data->count() > 0){
			
			$this->_data = $data->results();
			
			return true;
			
		}
		
		return false;
		
	}
		
	public function search(){

		if(Input::exists()){
			
			if(Input::get('q')){
				
				if(Token::check(Input::get('token'))){
				
					$validate = new Validate();
					
					$validation = $validate->check($_POST, array( 'q' => array( 'name' => "Search term", 'required' => true, 'min' => 2, 'max' => 20 )));
					
					if(!$validation->passed()){
						
						$temp = "";
						
						foreach($validation->errors() as $error){
							
							$temp .= $error . '<br />';
							
						}
						
						 Session::flash('error',$temp);
						 
						 return false;
					
					}
	
					$searchQuery = '[';
							
					$i = 0;
					
					$searchAbles = Neutron::getFromField($this->_fields,'searchAble');
					
					foreach($searchAbles as $props){
						
						$searchQuery.= '["'. $props .'", "LIKE", "%'. Input::get('q') .'%"]';
						
						if($i != (count($searchAbles) - 1)){
							
							$searchQuery.= ", \"OR\", ";
							
						}
						
						$i++;
						
					}
					
					$searchQuery .= ']';
					
					$data = $this->_db->get($this->_table, '*', $searchQuery);
					
					if($data->count() > 0){
						
						$this->_data = $data->results();
						
						return true;
						
					}
					
					return false;
					
				}
			
			}
			
		}
		
	}
		
	public function readThis($id){ 
	
		$data = $this->_db->get($this->_table, '*', '[["id", "=", "'.Input::get('view_id').'"], "LIMIT 1"]');
		
		if($data->count() > 0){
			
			$this->_data = $data->first();
			
			return true;
			
		}
		
		return false;
		
	}
		
	public function data(){
		
		return $this->_data;
		
	}
	
	public function fields(){
		
		return $this->_fields;
		
	}
	
	public function message(){
		
		return $this->_message;
		
	}
	
	public function title(){
		
		return $this->_title;
		
	}
	
	public function referencesTo(){
		
		return $this->_referencesTo;
		
	}
	
	public function name(){
		
		return $this->_name;
		
	}
	
	
	public function validations(){
		
		return (object) $this->_validations;
		
	}

	
	public function getSelectFieldFromDb($table, $field){
	
		$data = $this->_db->get($table, '*', '[["1", "=", "1"]]');
		
		if($data->count() > 0){
		
			$fields = [];
			
			foreach ($data->results() as $temp) {
			
				$fields[] = $temp->$field;
			
			}
			
			$fields = implode(',' , $fields);
			
			return $fields;
			
		}
		
		return false;
		
	
	}
	
}

?>