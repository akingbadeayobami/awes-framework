<?php

class _Course extends Controller{

	public function add(){
		
		$this->permission(true,'2');
		
		$this->processForm('addMissingCourse','course','missing',["course"=>Input::get('course')]);
		
		$this->renderHeader(['title' => "Add Missing Course", 'menu' => "classrep"]);
		
		$this->view('addcourse');
			
		$this->render('template/footer');
	
	}

	public function mates($courseid){
		
		$this->permission(true,'2');
		
		$course = $this->callFunc('Course','_getCourseFromID',[$courseid])->data;
		
		$this->renderHeader(['title' => $course . "'s Class List", 'menu' => "classrep"]);
		
		$this->view('courselist', [

				'coursemates' => $this->callFunc('course','mates',["courseid" => $courseid])->data,

				'course' =>$course
				
			]);
			
		$this->render('template/footer');
	
	}

}