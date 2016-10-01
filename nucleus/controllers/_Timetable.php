<?php

class _Timetable extends Controller{

	public function read(){
		
		$this->callFunc('Notification','clear',["type"=>'timetable']);
	
		$this->renderHeader(['title' => "Timetable"]);
		
		$timetable = $this->callFunc('Timetable','get');
			
		$this->view('timetable', [

			'mondays' =>  Filters::arrayWhere($timetable->data, 'day' , 'Monday'),

			'tuesdays' =>  Filters::arrayWhere($timetable->data, 'day' , 'Tuesday'),

			'wednesdays' => Filters::arrayWhere($timetable->data, 'day' , 'Wednesday'),

			'thursdays' => Filters::arrayWhere($timetable->data, 'day' , 'Thursday'),

			'fridays' => Filters::arrayWhere($timetable->data, 'day' , 'Friday'),

			'saturdays' => Filters::arrayWhere($timetable->data, 'day' , 'Saturday'),

			'advert' => $this->callFunc('Adverts','get')->data

			]);
			
		$this->render('template/footer');
	
	}

	public function set(){
	
		$this->permission(true,'2');
		
		$this->processForm('addToTimetable','Timetable','add',["course"=>Input::get('course'), "day"=>Input::get('day'), "timefrom"=>Input::get('timeFrom'), "timeto"=>Input::get('timeTo'), "venue"=>Input::get('venue'), "lecturer"=>Input::get('lecturer')]);
		
		$this->processForm('removeTimetable','Timetable','remove',["id"=>Input::get('id')]);
			
		$this->renderHeader(['title' => "Timetable", 'menu' => "classrep"]);
		
		$timetable = $this->callFunc('Timetable','get');
				
		$this->view('settimetable', [

			'myCourses' => $this->callFunc('Course','my')->data,

			'mondays' =>  Filters::arrayWhere($timetable->data, 'day' , 'Monday'),

			'tuesdays' =>  Filters::arrayWhere($timetable->data, 'day' , 'Tuesday'),

			'wednesdays' => Filters::arrayWhere($timetable->data, 'day' , 'Wednesday'),

			'thursdays' => Filters::arrayWhere($timetable->data, 'day' , 'Thursday'),

			'fridays' => Filters::arrayWhere($timetable->data, 'day' , 'Friday'),

			'saturdays' => Filters::arrayWhere($timetable->data, 'day' , 'Saturday'),

			]);
			
		$this->render('template/footer');
	
	}

}