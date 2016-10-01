<?php

class _Classthread extends Controller{

	public function read($page = 1){
		
		$this->processForm('postClassThread','Classthread','post',["message"=>Input::get('message')]);
		
		$this->renderHeader(['title' => "Class Thread"]);
		
		$this->callFunc('Notification','clear',["type"=>'classthread']);
		
		$this->view('classthread', [

			'profile' => $this->callFunc('profile','get', ["person"=>Session::get('matric')])->data,

			'thread' => $this->callFunc('Classthread','get',["page"=>$page])->data,

			'nextPage' => Route::to('classthread/read/'  . ++$page)

			]);
			
		$this->render('template/footer');
	
	}

}