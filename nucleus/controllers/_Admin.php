<?php

class _Admin extends Controller{
	
	public function questions(){
		
		$this->render('admin/body',[
		
			'instance' => new Questions() 
		
		]);
	
	}
	
	public function schools(){
		
		$this->render('admin/body',[
		
			'instance' => new Schools() 
		
		]);
	
	}
	
	public function blog(){
		
		$this->render('admin/body',[
		
			'instance' => new Blog() 
		
		]);
	
	}

	public function courses(){
		
		$this->render('admin/body',[
		
			'instance' => new Courses() 
		
		]);
	
	}

	public function departments(){
		
		$this->render('admin/body',[
		
			'instance' => new Departments()
		
		]);
	
	}

	public function faculties(){
		
		$this->render('admin/body',[
		
			'instance' => new Faculties() 
		
		]);
	}

	public function features(){
		
		$this->render('admin/body',[
		
			'instance' => new Features() 
		
		]);
	}
	
	public function messages(){
		
		$this->render('admin/body',[
		
			'instance' => new Messages() 
		
		]);
	}
	
	public function specials(){
		
		$this->render('admin/body',[
		
			'instance' => new Specials() 
		
		]);
	}

	public function analytics(){
		
		$this->render('admin/body',[
		
			'instance' => new Analytics() 
		
		]);
	}

}