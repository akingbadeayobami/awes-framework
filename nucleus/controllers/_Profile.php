<?php

class _Profile extends Controller{
	
	public function read($page = 1){
		
		$this->processForm('likeActivity','Activities','like',["id"=>Input::get('id')]);
		
		$this->renderHeader(['title' => "My Profile", 'menu' => "profile"]);
		
		$this->view('myprofileview', [

			'activities' =>  $this->callFunc('Activities','mine',["person"=> Session::get('matric'), "page"=> $page])->data,

			'profile' => $this->callFunc('profile','get', ["person"=>Session::get('matric')])->data,

			'myCourses' => $this->callFunc('course','my')->data,

			'nextPage' => Route::to('profile/read/'. ++$page) 

			]);
			
		$this->render('template/footer');
	
	}

	public function person($person, $page = 1){
		
		$this->processForm('likeActivity','Activities','like',["id"=>Input::get('id')]);
		
		$profile = $this->callFunc('profile','get', ["person"=>$person]);
		
		$this->renderHeader(['title' => $profile->data->dname . "'s Profile"]);
		
		$this->view('profileview', [

			'activities' =>  $this->callFunc('Activities','mine',["person"=>$person, "page"=>$page])->data,

			'profile' => $profile->data,

			'nextPage' => Route::to('profile/person/' + $person + '/'. ++$page)

			]);
			
		$this->render('template/footer');
	
	}

	public function edit(){
		
		$this->processForm('updateProfile','Profile','update',["lname"=>Input::get('lname'),"fname"=>Input::get('fname'), "dname"=>Input::get('dname'), "aboutme"=>Input::get('aboutme'), "hobbies"=>Input::get('hobbies'), "dob"=>Input::get('dob'), "sex"=>Input::get('sex')] );
		
		$this->processForm('updateStatus','Profile','updatestatus',["status"=>Input::get('status')]);
		
		$this->processForm('changePassword','User','changePassword',["oldpass"=>Input::get('oldpass'), "newpass"=>Input::get('newpass')]);
		
		$this->processForm('changeColor','Profile','changeColor',[Input::get('changeColor')]);
		
		$this->processForm('changeDP','Profile','changeDP');
		
		$this->renderHeader(['title' => "Profile Edit", 'menu' => "profile"]);
		
		$this->view('profileedit', [

			'profile' =>  $this->callFunc('profile','get', ["person"=>Session::get('matric')])->data,

			]);
			
		$this->render('template/footer');
	
	}

	public function setup(){
		
		$this->processForm('updateSettings','User','Settings',["course"=>Input::get('course'), "department"=>Input::get('department'), "level"=>Input::get('level')]);
		
		$this->processForm('removeCourse','Course','remove',["course"=>Input::get('course')]);
		
		$this->processForm('addCourse','Course','add',["course"=>Input::get('course')]);
		
		$this->renderHeader(['title' => "Account Setup", 'menu' => "profile"]);
		
		$profile = $this->callFunc('profile','get', ["person"=>Session::get('matric')])->data;
		
		$search = (Input::get('search')) ? Input::get('search') : "LordPein"; // Just to make sure there is no course
		
		$this->view('accountsetup', [

			'userCheck' => $this->callFunc('User','check')->data,

			'faculties' => $this->callFunc('Course','allFaculties')->data,

			'departments' => $this->callFunc('Course','allDepartments',["id"=>$profile->facultyID])->data,

			'allCourse' => $this->callFunc('Course','all',[$search])->data,

			'myCourses' => $this->callFunc('Course','my')->data,

			'profile' => $profile

			]);
			
		$this->render('template/footer');
	
	}

	public function role(){
		
		$this->processForm('dropClassRepRole','Classreprole','drop');
		
		$this->processForm('takeClassRepRole','Classreprole','take');
			
		$this->renderHeader(['title' => "Class Rep Role Manager", 'menu' => "profile"]);
		
		$this->view('classreprole', [
				
			'profile' => $this->callFunc('profile','get', ["person"=>Session::get('matric')])->data,

			'classreps' => $this->callFunc('Classreprole','manage')->data,

			]);
			
		$this->render('template/footer');
	
	}

}