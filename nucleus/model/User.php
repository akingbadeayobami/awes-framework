<?php

 class User extends Model{

    use ClassInterface;

    public $_validations = [

      'email'=> "text|title:Email|required|min:3|max:24",

      'password'=> "password|title:Password|required|min:3|max:24|pattern:\w{1,}:Password Must Be Awesome",

      'repassword'=> "password|title:Email|required:true|min:3|max:24",

      'phone_number'=> "number|title:Email|required:true|min:3|max:24|pattern:^\d{9}$",

    ];

    protected $table = "users";

    public function signin(){

      if(!Auth::attempt(Input::only('email,password'))){

        $this->_message = "Invalid Login";

        return false;

      }

      if(!Auth::activated()){

        $this->_message = "Account Not Activated";

        return true;

      }

      return true;

    }



  }

?>
