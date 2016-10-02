<?php

namespace Nucleus\Controllers;

class _Contact extends Controller{

	public function Us(){

		$this->action('sendMessage','Contact','us',Input::all());

		$this->view('contactus');

	}

}
