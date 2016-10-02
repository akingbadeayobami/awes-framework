<?php

namespace Nucleus\Model;

use Nucleus\Core\Model;

 class User extends Model{

    public $_validations = [

      'email'=> "email|title:E-mail|required|min:3|max:24", // |unique:users

      'fname'=> "text|title:Last Name|required|min:3|max:24",

      'lname'=> "text|title:First Name|required|min:3|max:24",

      'password'=> "password|title:Password|required|min:3|max:24|pattern:\w{1,}:Password Must Be Awesome",

      'repassword'=> "password|title:Re-Password|required:true|matches:password",

      'phone_number'=> "number|title:Email|required:true|min:3|max:24|pattern:^\d{9}$",

    ];

    protected $table = "users";

    public function hasProfile($user_id){

    //  return Profile::where('user_id',$user_id)->first();

    }

    public function hasStatus($user_id){

      // return Status::

    }

  }

?>
