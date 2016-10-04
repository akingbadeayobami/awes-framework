<?php

namespace Nucleus\Services;

use Nucleus\Core\Auth;
use Nucleus\Core\Redirect;

class Middleware {

	public function auth(){

    if(!Auth::check()){

      return Redirect::to('auth.signin');

    }

    return true;

  }

	public function hasRole($role){

    if(Auth::user()->role !== $role){

      return Redirect::to('auth.signin');

    }

    return true;

  }

	public function guest(){

		if(Auth::check()){

			Redirect::to('');

		}

	}

  // 	public static function hasPemission($role);

}

?>
