<?php

class _Materials extends Controller{

	public function read($courseID){
		
		$course = $this->callFunc('Course','_getCourseFromID',[$courseID])->data;
		
		$this->renderHeader(['title' => $course . "'s Materials", 'menu' => "materials"]);
	
		$this->view('viewcoursematerials',[
		
			'course' => $course,
		
			'folders' => $this->callFunc('Materialfolder','get',["courseid"=>$courseID])->data,
		
		]);
			
		$this->render('template/footer');
	
	}

	public function add(){
		
		$folderCreated = $this->processForm('newMaterialFolder','Materialfolder','add',["course"=>Input::get('course'), "type"=>Input::get('type'), "title"=>Input::get('title'), "description"=>Input::get('description')]);
		
		if(isset($folderCreated->status)){
		
			Redirect::to(Route::to('materials/managefolder/' . $folderCreated->data));
			
		}
		
		$this->renderHeader(['title' => "Add New Material Folder", 'menu' => "materials"]);
		
		$this->view('newmaterialfolder',[
		
			'myCourses' => $this->callFunc('course','my')->data,
		
		]);
			
		$this->render('template/footer');
	
	}

	public function managefolder($folderID){
		
		$this->processForm('updateDetails','Materialfolder','update',["id"=>Input::get('id'), "course"=>Input::get('course'), "type"=>Input::get('type'), "title"=>Input::get('title'), "description"=>Input::get('description')]);
		
		$this->processForm('upload','Materialfolder','upload',["folderid"=>$folderID]);
		
		$this->processForm('deleteMaterial','Materialfolder','deleteMaterial',["id"=>Input::get('deleteMaterial')]);
		
		$folderContent = $this->callFunc('Materialfolder','content',["folderid"=>$folderID])->data;
		
		$this->renderHeader(['title' => "Manage " . $folderContent['details']->title, 'menu' => "materials"]);
		
		$this->view('managematerialfolder', [

				'images' => Filters::arrayWhere($folderContent['content'], 'type' , 'image'),

				'docs' =>  Filters::arrayWhere($folderContent['content'], 'type' , 'doc'),

				'ppts' => Filters::arrayWhere($folderContent['content'], 'type' , 'ppt'),

				'pdfs' => Filters::arrayWhere($folderContent['content'], 'type' , 'pdf'),

				'contentLength' => count($folderContent['content']),
				
				'myCourses' => $this->callFunc('course','my')->data,
				
				'details' =>$folderContent['details']
				
				
			]);
			
		$this->render('template/footer');
	
	}

	public function folder($folderID){
		
		$this->callFunc('Notification','clear',["type"=>'materials', "targetID"=>$folderID]);
		
		$folderContent = $this->callFunc('Materialfolder','content',["folderid"=>$folderID])->data;
		
		$this->renderHeader(['title' => $folderContent['details']->title . "'s Content", 'menu' => "materials"]);

		$this->view('viewfoldermaterial', [

				'images' => Filters::arrayWhere($folderContent['content'], 'type' , 'image'),

				'docs' =>  Filters::arrayWhere($folderContent['content'], 'type' , 'doc'),

				'ppts' => Filters::arrayWhere($folderContent['content'], 'type' , 'ppt'),

				'pdfs' => Filters::arrayWhere($folderContent['content'], 'type' , 'pdf'),

				'revenue' => Filters::arrayWhere($folderContent['content'], 'type' , 'revenue'),

				'contentLength' => count($folderContent['content']),

				'details' =>$folderContent['details']
				
			]);
			
		$this->render('template/footer');
	
	}

	public function manage(){
		
		$this->processForm('deletefolderID','Materialfolder','delete',["id"=>Input::get('deletefolderID')]);
		
		$this->renderHeader(['title' => "Manage Materials", 'menu' => "materials"]);

		$this->view('managematerials', [

				'folders' => $this->callFunc('Materialfolder','mine')->data

			]);
			
		$this->render('template/footer');
	
	}

}