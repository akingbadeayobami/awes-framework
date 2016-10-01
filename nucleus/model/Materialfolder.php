<?php
class Materialfolder extends ClassInterface{
	
	protected $_table = 'materialfolder';
	
	
	protected $_validations = 
	
	[
	
		"add" => [ 
	   
		   'course'=>['name' => 'Course', 'required' => true, 'pattern' => ["%^[A-Za-z]{3}\s[0-9]{3}$%", "Course Seems To Be Invalid"]], 
			
			'type'=>['name' => 'Type', 'required' => true, 'min' => 3, 'max' => 32], 
			
			'title'=>['name' => 'Title', 'required' => true, 'min' => 3, 'max' => 32], 
			
			'description'=>['name' => 'Description', 'required' => true, 'min' => 3, 'max' => 250]
			
		 ],
		 
		"update" => [ 
	   
		   'id'=>['name' => 'ID', 'required' => true], 
			
		   'course'=>['name' => 'Course', 'required' => true, 'pattern' => ["%^[A-Za-z]{3}\s[0-9]{3}$%", "Course Seems To Be Invalid"]], 
			
			'type'=>['name' => 'Type', 'required' => true, 'min' => 3, 'max' => 32], 
			
			'title'=>['name' => 'Title', 'required' => true, 'min' => 3, 'max' => 32], 
			
			'description'=>['name' => 'Description', 'required' => true, 'min' => 3, 'max' => 250]
			
		 ],
		 
		 "get" => [
		 
			'id' => ['name' => 'ID', 'required' => true]
		 
		 ]
	
	];
	
	
	public function add(){
	
		$course = Input::get('course');
		
		$type = Input::get('type');
		
		$title = Input::get('title');
		
		$description = Input::get('description');
		
		$Course = new Course;
		
		if(!preg_match("%[A-Za-z]{3}\s[0-9]{3}%",$course) || !$Course->isCourseValid($course)){
		
			$this->_message = "Course Seems To Be Invalid";
	
			return false;
			
		}
	
		$fields = array(		

			'course' => $course,

			'type' => $type,

			'title' => $title,

			'description' => $description,

			'person' => Session::get('matric'),
			
			'approved' => 'no',
			
			'created' => time(),
			
			'updated' => time()
			
		 );
		 
		 $insert = $this->_db->insert($this->_table, $fields);

		if(!$insert){
		
			$this->_message = 'An Error Ocurred while processing your request';
		
			return false;
		
		}
		
		$data = $this->_db->get($this->_table, 'id', '["1", "ORDER BY id DESC LIMIT 1"]');
		
		$this->_data = $data->first()->id;
		
		$this->_message = 'Folder Created Successfully';
		
		return true;
		
	}
	
	public function delete(){ 
		
		$id = Input::get('id');
		
		if(!$this->_db->delete($this->_table, $id)){
		
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
			
		}
		
		$this->_message = "Folder Deleted Successfully";
		
		return true;
		
	}
	
	public function update(){
	
		$id = Input::get('id');
		
		$course = Input::get('course');
		
		$type = Input::get('type');
		
		$title = Input::get('title');
		
		$description = Input::get('description');
		
		$fields = array(		

			'course' => $course,

			'type' => $type,

			'title' => $title,

			'description' => $description
			
		 );
		 
		if($this->_db->update($this->_table, $id, $fields)){

			$this->_message = 'Folder Details Updated Succesfully';
			
			return true;
			
		}else {
			
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
		
		}
		
	}
	
	public function get(){
	
	$courseid = Input::get('courseid');
	
	$Course = new Course;

	$course = $Course->getCourseFromID($courseid);
	
	$data = $this->_db->get('profile JOIN materialfolder ON materialfolder.person = profile.matric', 
	
						'profile.matric, profile.dname, materialfolder.id, materialfolder.title, materialfolder.type, materialfolder.description, materialfolder.created, materialfolder.updated', 
						
						'[["materialfolder.course", "=", "' . $course . '"], "ORDER BY materialfolder.updated DESC"]');
		
		if(!$data->error()){
		
			foreach($data->results() as $temp){
			
				$data1 = $this->_db->get('materialsrc', 'COUNT(*) AS num', '[["refid", "=", "'.$temp->id.'"]]'); 
				
				$temp->numofcontent = $data1->first()->num;
				
				$data2 = $this->_db->get('materialsrc', 'src', '[["refid", "=", "'.$temp->id.'"], "AND", ["type", "=", "image"], "LIMIT 1"]');
				
				if($data2->count() == 1){
					
					$temp->coverImage = $data2->first()->src;
				
				}else{
				
					$temp->coverImage = 'assets/images/materials/default.jpg';
				
				}
				
				$temp->kind = 'content';
				
				$this->_data[] = $temp;
				
			}
			
			if(count($this->_data) > 1){
			
				$Adverts = new Adverts();	
			
				$rawAdvert = $Adverts->serve('banner');
			
				if($rawAdvert){
			
					$rawAdvert->kind = 'revenue';
					
					array_splice($this->_data,0,0,[$rawAdvert]);				
				}
			
			}
		
			
			return true;
		
		}
		
		
		$this->_message = 'An Error Ocurred while processing your request';
		
		return false;
			
		
	}
	
	public function mine(){
	
	$data = $this->_db->get($this->_table, '*', '[["person", "=", "' . Session::get('matric') . '"], "ORDER BY id DESC"]');
		
		if(!$data->error()){
		
			foreach($data->results() as $temp){
			
				$data1 = $this->_db->get('materialsrc', 'COUNT(*) AS num', '[["refid", "=", "'.$temp->id.'"]]'); 
				
				$temp->numofcontent = $data1->first()->num;
				
				$data2 = $this->_db->get('materialsrc', 'src', '[["refid", "=", "'.$temp->id.'"], "AND", ["type", "=", "image"], "LIMIT 1"]');
				
				if($data2->count() == 1){
					
					$temp->coverImage = $data2->first()->src;
				
				}else{
				
					$temp->coverImage = 'assets/images/materials/default.jpg';
				
				}
				
				$this->_data[] = $temp;
				
			}
			
			return true;
		
		}
		
		
		$this->_message = 'An Error Ocurred while processing your request';
		
		return false;
			
		
	}
	
	public function content(){
		
		$folderid = Input::get('folderid');
		
		$data1 = $this->_db->get($this->_table, '*', '[["id", "=", "' . $folderid . '"], "LIMIT 1"]');

		if($data1->error()){
			
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
			
		}
			
		$this->_data['details'] = $data1->first();
		
		$data2 = $this->_db->get('materialsrc', '*', '[["refid", "=", "' . $folderid . '"], "ORDER BY id DESC"]');
		
		if($data2->error()){
			
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
			
		}
		
		$this->_data['content'] = $data2->results();
		
		if(count($this->_data['content']) > 1){
		
			$Adverts = new Adverts();	
				
			$rawAdvert = $Adverts->serve('banner');
			
			if($rawAdvert){
			
				$rawAdvert->type = 'revenue';
				
				array_splice($this->_data['content'],0,0,[$rawAdvert]);
			
			}
		
		}
				
		return true;
		
	}
	
	public function upload(){ 
		
		$folderid = Input::get('folderid');
		
		$data = $this->_db->get($this->_table, 'course', '[["id", "=", "' . $folderid . '"], "LIMIT 1"]');
		
		$temp = $data->first();
		
		$course = $temp->course;
	 
		if (!empty($_FILES)){
		
			$fileField = 'files';
			
			for($i=0; $i < count($_FILES[$fileField]['name']); $i++) {
	
				$fileName = $_FILES[$fileField]["name"][$i];
				
				$name = substr($fileName, 0 , strpos($fileName, "."));
				
				$fileType = $_FILES[$fileField]["type"][$i];
				
				$fileSize = $_FILES[$fileField]["size"][$i];
				
				$fileextension = strtolower(substr($fileName , strpos($fileName , '.') + 1));

				$uploadDirectory = 'assets/materials/' . Config::get('mysql/db') . '/' . $course . '/' . $folderid . '/';
				
				$tempLocation = $_FILES[$fileField]["tmp_name"][$i];
				
				if (($fileType != "image/jpeg") && ($fileType != "image/png") && ($fileType != "image/gif") && ($fileType != "application/pdf") && ($fileType != "application/zip") && ($fileType != "application/msword") && ($fileType != "application/vnd.ms-powerpoint") && ($fileType != "application/vnd.openxmlformats-officedocument.wordprocessingml.document") && ($fileType != "application/vnd.openxmlformats-officedocument.presentationml.presentation")){ 
					
					$this->_message = " Invalid File" ; 
					
					return	false;
					
				}
				
				$fileName = md5($fileName); 
				
				switch($fileType){
					case "image/jpeg":
					$fileName = $fileName.'.jpg';
					$type = "image";
					break;
					case "image/png":
					$fileName = $fileName.'.png';
					$type = "image";
					break;
					case "image/gif":
					$fileName = $fileName.'.gif';
					$type = "image";
					break;	
					case "application/pdf":
					$fileName = $fileName.'.pdf';
					$type = "pdf";
					break; 
					case "application/zip":
					$fileName = $fileName.'.zip';
					$type = "zip";
					break;	
					case "application/vnd.openxmlformats-officedocument.presentationml.presentation":
					$fileName = $fileName.'.pptx';
					$type = "ppt";
					break;
					case "application/vnd.ms-powerpoint":
					$fileName = $fileName.'.ppt';
					$type = "ppt";
					break;	
					case "application/msword":
					$fileName = $fileName.'.doc';
					$type = "doc";
					break;
					case "application/vnd.openxmlformats-officedocument.wordprocessingml.document":
					$fileName = $fileName.'.docx';
					$type = "doc";
					break;
				}
				
				if ( $fileSize > 10485760 ) { 	// 10MB
				
					$this->_message = "File Too Large" ; 
					
					return	false;
					
				}
				
				$UD = dirname( __FILE__ ) .  "../../../$uploadDirectory";
				
				if (!file_exists($UD)){
				  
					 mkdir($UD, 0777, true);
			 
				}
				
				$fileLocation = $UD.$fileName; 
				
				if (file_exists($fileLocation)) {
				
					$this->_message = "It Seems You Have Uploaded This File Before. If You Insist Using It Please Try Renaming It" ; 
					
					return true;
					
				}
				
				move_uploaded_file($tempLocation,$fileLocation);
				
				if($type == "image"){	
			
					Watermark::watermarkText($fileLocation);
				
				}
				
				$fileLocation = $uploadDirectory.$fileName;
				
				$data = array(
					
					"refid" => $folderid,
					
					"src" => $fileLocation,
					
					"type" => $type,
					
					"name" => $name,
					
					"time" => time()
							
				);
				
				$insert = $this->_db->insert('materialsrc', $data);
				
				if(!$insert){
				
					$this->_message = 'An Error Ocurred while processing your request';
				
					return false;
			
				}
			
			}

			 
			$this->_db->update($this->_table, $folderid, array('updated' => time()));
			
			$Profile = new Profile;
			
			$dname = $Profile->getWhatFromMatric('dname');
			
			$Notification = new Notification;
			
			$i++;
			
			$Notification->create("$dname added $i new material(s) for $course",$folderid,"materials",$course);
			
			$this->_message = 'Files Uploaded Successfully';
			
			return true ; 
		
		}	

	} 

	public function deleteMaterial(){ 
		
		$id = Input::get('id');
		
		$data = $this->_db->get('materialsrc', 'src', '[["id", "=", "' . $id . '"], "LIMIT 1"]');
		
		$temp = $data->first();
		
		$src = $temp->src;
	 
		 if (file_exists(dirname( __FILE__ ) . "../../../$src")) {
		
			unlink(dirname( __FILE__ ) . "../../../$src");
		
		} 
		
		if(!$this->_db->delete('materialsrc', $id)){
	
			$this->_message = 'An Error Ocurred while processing your request';
			
			return false;
				
		}
		
		$this->_message = 'Material Deleted Successfully';
		
		return true;
		
	} 

}
?>