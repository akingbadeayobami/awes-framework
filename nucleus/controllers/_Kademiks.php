<?php

class _Kademiks extends Controller{

	public function features(){
		
		$this->renderHeader(['title' => "Features"]);
		
		$this->view('features', [

			'features' => $this->callFunc('Features','read')->data,

			]);
			
		$this->render('template/footer');
	
	}

	public function downloadapp(){
		
		$this->renderHeader(['title' => "Download App"]);
		
		$this->view('downloadapp');
			
		$this->render('template/footer');
	
	}

	public function contactAdmin(){
		
		$this->processForm('contactAdmin','Contact','admin',["name"=>Input::get('name'), "email"=>Input::get('email'), "message"=>Input::get('message'), "subject"=>Input::get('subject'), "type"=>Input::get('type')]);
		
		$this->renderHeader(['title' => "Contact Admin"]);
		
		$this->view('contactadmin', [
		
			"profile" => $this->callFunc('profile','get', ["person"=>Session::get('matric')])->data
			
		]);
			
		$this->render('template/footer');
	
	}

}