<?php
class Adverts extends ClassInterface{
	

	public function checkForExpiredAdverts(){

		$banner = 'null';
			$duration = $time2 - $time1;
	$duration = $miscell_functions->disintegrateTimestamp($duration);
	$subject = FULL_NAME . " Advert Analysis";
	$message = " <p>This is the analysis of how the advert units you placed in " . FULL_NAME . " was used </p>
Number of Impression - $numImpression <br />
Number of Read More  - $numClickMore <br />
Number of Click More  - $numClickonLink <br />
Number of Distinct viewers - $numClickonLink <br />
Duration of Adverts - 	$duration <br />
	";
	$miscell_functions->sendMail($email,$subject,$message);

		if (!empty($_FILES)){
		
			$fileField = 'file';

			$fileName = $_FILES[$fileField]["name"];
							
			$fileType = $_FILES[$fileField]["type"];
			
			$fileSize = $_FILES[$fileField]["size"];

			$uploadDirectory = 'assets/images/banners/' . Config::get('mysql/db') . '/';
			
			$tempLocation = $_FILES[$fileField]["tmp_name"];
			
			if (($fileType != "image/jpeg") && ($fileType != "image/png") && ($fileType != "image/gif")){ 
				
				$this->_message = "Invalid File" ; 
				
				return	false;
						
			}
			
			$fileName = md5($fileName); 

			switch($fileType){ case "image/jpeg":  $fileName = $fileName.'.jpg'; break; case "image/png": $fileName = $fileName.'.png'; break; case "image/gif": $fileName = $fileName.'.gif'; break; }
			
			if ( $fileSize > 2097152 ) { 	

				$this->_message = "File Too Large" ; 
				
				return	false;
						
			}
			
			$UD = dirname( __FILE__ ) .  "../../../$uploadDirectory";
			
			if (!file_exists($UD)){
			  
				 mkdir($UD, 0777, true);
		 
			}
			
			$fileLocation = $UD.$fileName; 
			
			$banner = $uploadDirectory.$fileName;
			
			if (!file_exists($fileLocation)) {

				move_uploaded_file($tempLocation,$fileLocation);
			
			}
						
		}	

	
		$fields = array(		
			
			'matric' => Session::get('matric'),
			
			'label' => Input::get('label'),
			
			'caption' => Input::get('caption'),

			'details' => Input::get('details'),

			'link' => Input::get('link'),
			
			'banner' => $banner,
			
			'units' => Input::get('amount'),

			'approved' => 'no',
			
			'target' => Input::get('target'),
			
			'amount' => Input::get('amount'),

			'bank' => Input::get('bank'),

			'teller' => Input::get('teller'),

			'created' => time()

		);

		if(!$this->_db->insert($this->_table, $fields)){
			
			$this->_message = 'An Error Ocurred while processing your request';
		
			return false;
		
		}
		
		
		$this->_message = 'Advert Created Successfully. Subject To Confirmation';
		
		return true;
		
	}
	
	public function CheckForBirthdays(){ 
	
		// return false;
	
		$User = new User;
		
		$faculty = $User->getWhatFromMatric('faculty');
		
		$data = $this->_db->get($this->_table, 'id,matric,label,caption,details,link,banner,units', '[["approved", "=", "yes"], "AND", ["units", ">", "0"], "AND ( ", ["target", "=", "0"] , "OR", ["target", "=", "'.$faculty.'"], " ) ORDER BY RAND() LIMIT 1"]');
		
		if($data->count() == 0){
		
			return false;
		
		}
		
		$temp = $data->first();
	
		// $this->account($temp->id,'i',$temp->units);
	
		return $temp;
		
	}
	
	public function view($id){ 
		
		$data = $this->_db->get($this->_table, 'id,matric,label,caption,details,link,banner,units', '[["id", "=", "'.$id.'"], "LIMIT 1"]');
		
		$temp = $data->first();
		
		$this->account($temp->id,'v',$temp->units);
		
		$this->_data = $temp;
		
		return true;
		
	}
	
	public function account($id,$type,$units){ 
		
		$fields = array(

			'advertid' => $id,
				
			'type' => $type,
					
		);
		
		if($this->_db->insert('advertusage', $fields)){
		
			switch($type){
			
				case 'i':
				
					$deduction = 1;
				
				break;
				
				case 'v':
				
					$deduction = 2;
				
				break;
				
			}
			
			$units = $units - $deduction;
		
			if($this->_db->update($this->_table, $id, array( 'units' => $units ))){
			
				return true;
			
			}
			
			return false;
		
		}
		
	}
	
}

?>