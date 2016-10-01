<?php

 class User extends Model{

    use ClassInterface;

    public $_validations = [

      'email'=> "text,title:Email,required,min:3,max:24",

      'password'=> "password,title:Email,required,min:3,max:24",

      'repassword'=> "password,title:Email,required:true,min:3,max:24",

      'phone_number'=> "number,title:Email,required:true,min:3,max:24,pattern:/d{9}/",

    ];

    protected $table = "users";

    public function signin(){

      if(!Auth::attempt(Input::only('email,password'))){

        $this->message = "Invalid Login";

        return false;

      }

      if(!Auth::activated()){

        $this->message = "Account Not Activated";

        return true;

      }

      return true;

    }



  }

?>
