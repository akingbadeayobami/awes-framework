<?php
class Middleware {

	public static function auth(){

    if(!Auth::check()){

      return Redirect::to(Route::to('auth/signin'));

    }

    return true;

  }

	public static function hasRole($role){

    if(Auth::user()->role !== $role){

      return Redirect::to(Route::to('auth/signin'));

    }

    return true;

  }

	public static function guest(){
			// TODO guest
		// if(!Auth::check()){

	//	Redirect::to(Route::to(''));

		//}

	}

  // 	public static function hasPemission($role);

}

?>
