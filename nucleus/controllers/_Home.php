<?php

class _Home extends Controller{

	public function index(){

		return $this->view('index',['name1'=> "Akingbade",'name'=> "Akingbade"]);

	}

}
