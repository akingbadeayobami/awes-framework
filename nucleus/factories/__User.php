<?php

namespace Nucleus\Factories;

use Nucleus\Core\Factory;

 class __User {

    use Factory;

    public function signin(){

      $attempt = Auth::attempt(Input::only('email,password'),Input::has('rememberMe'));

      if(!$attempt){

        $this->_message = "Invalid Login";

        return false;

      }

      if($attempt === 2){

        $this->_message = "Account Not Activated";

        return false;

      }

      $this->_message = "Log In Successfull";

      return true;

    }

    public function signup(){

      Auth::create(Input::only('email,fname,lname'),'password');

      $this->_message = "Account Created Successfully. Please Check Your Mail To Activate Your Account";

      return true;

    }

    public function signOut(){

      Auth::logOut();

      return true;

    }

  }

?>
