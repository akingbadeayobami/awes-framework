<?php

class _Message extends Controller{

	public function read(){
		
		$this->renderHeader(['title' => "Message"]);
		
		$this->view('messages', [

				'messages' => $this->callFunc('messages','getMyMessages')->data, // // '-messages[0].time'
				
				'advert' => $this->callFunc('Adverts','get')->data
				
			]);
			
		$this->render('template/footer');
	
	}


	public function thread($person,$page = 1){
		
		$this->callFunc('Notification','clear',["type"=>'message', "targetID"=>$person]);
		
		$this->callFunc('messages','readMessage',["person"=>$person]);
		
		$this->processForm('sendMessage','messages','send',["receiver"=>$person,"message"=>Input::get('message')]);
		
		$profile = $this->callFunc('profile','get',["person"=>$person])->data;
		
		$this->renderHeader(['title' => "Messages With " . $profile->dname]);
		
		$this->view('messagethread', [

				'messages' => $this->callFunc('messages','getThread',["person"=>$person,"page"=>$page])->data,

				'profile' =>$profile,

				'myProfile' => $this->callFunc('profile','get',["person"=>Session::get('matric')])->data,

				'nextPage' => Route::to('message/thread/' . $person . "/" . ++$page)

			]);
			
		$this->render('template/footer');
	
	}

}