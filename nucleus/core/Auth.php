<?php

namespace Nucleus\Core;

use Nucleus\Core\Model;
use Nucleus\Core\Session;
use Nucleus\Core\Cookie;
use Nucleus\Core\Hash;

class Auth{

	private static $_check = null;

	private static $_user = null;

	private static $_id = null;

	public static function attempt($loginParameters,$rememberMe = true){

		$keys = array_keys($loginParameters);

		$user = Model::table(cg('auth.table'))->where($keys[0],$loginParameters[$keys[0]])->first();

		if(!$user){

			return false;

		}

		if(!Hash::checkPassword($loginParameters[$keys[1]],$user->password)){

			return false;

		}

		if(cg('auth.activation')){

			if($user->active == '0'){

				return 2; // actually a falsy truth

			}

		}

		Model::table(cg('auth.table'))->updateId($user->id,[

			'last_login' => Neutron::now()

		]);

		Session::put(cg('session.name'), $user->id);

		if($rememberMe){

			$hash = Neutron::randomUniqueTo(32,cg('session.table'),'hash');

			if(Model::table(cg('session.table'))->where('user_id',$user->id)->count() == 0){

				Model::table(cg('session.table'))->create([

					'user_id' => $user->id,

					'hash' => $hash,

					'created_at' => Neutron::now()

				]);

			}else{

				Model::table(cg('session.table'))->where('user_id',$user->id)->update([

					'hash' => $hash

				]);

			}

			Cookie::put(cg('cookie.name'),$hash,cg('cookie/expiry'));

		}

		return true;

	}

	public static function create($fields = [], $password){

		$fields[$password] = Hash::password(Input::get($password));

		if(cg('auth.activation')){

			$fields['active'] = 0;

		}

		$fields['joined'] = $fields['last_login'] = Neutron::now();

		$user_id = Model::table(cg('auth.table'))->create($fields);

		if(cg('auth.activation')){

			$activationCode = Neutron::randomUniqueTo(22,cg('auth.activation_table'),'hash');

			Model::table(cg('auth.activation_table'))->create([

				'user_id' => $user_id,

				'hash' => $activationCode,

				'created_at' => Neutron::now()

			]);

			// Mail::send('activation',"xxx");

		}

		return $user_id;

	}

  public static function id(){

		if(self::$_id){

			return self::$_id;

		}

		if(Model::table(cg('auth.table'))->where('id', Session::get(cg('session.name')))->count()){

			return self::$_id = Session::get(cg('session.name'));

		}

		return false;

  }

  public static function user(){

		if(self::$_user){

			return self::$_user;

		}

		if(Auth::id()){

			return self::$_user = Model::table(cg('auth.table'))->where('id', Auth::id() )->first();

		}

			return false;

	}

  public static function check(){

		if(self::$_check){

			return self::$_check;

		}

		if(Session::get(cg('session.name')) && self::id()){

			return self::$_check = true;

		}

		if(Cookie::exists(cg('cookie.name'))){

		  $hashCheck = Model::table(cg('session.table'))->where('hash',Cookie::get(cg('cookie.name')))->first();

			if($hashCheck){

				 Session::put(cg('session.name'), $hashCheck->user_id);

				 Model::table(cg('auth.table'))->updateId($hashCheck->user_id, [

					 'last_login' => Neutron::now()

				 ]);

				 return self::$_check = true;

			}

		}

		return self::$_check = false;

  }

	public static function logOut(){

		if(!self::check()){

			return true;

		}

		Cookie::delete(cg('cookie.name'));

		Model::table(cg('session.table'))->where('user_id',Session::get(cg('session.name')))->delete();

		Session::delete(cg('session.name'));

		return true;

	}

	public static function activateAccount(){

		if($user = Model::table(cg('activation.table'))->where('hash', Input::get('activatecode'))->first()){

			Model::table(cg('activation.table'))->where('hash', Input::get('activatecode'))->delete();

			if(Model::table(cg('auth.table'))->updateId($user->user_id,['active'=>1])){

				$this->_message = 'Your Account Has Been Verified Successfully';

				return true;

			}

		}

		$this->_message = 'Sorry You Account Was Not Successfully Validated';

		return false;

	}

	public static function recoverPassword(){

		$email = Input::get('email');

		$data = $this->_db->get('profile JOIN users ON profile.matric = users.matric', 'users.id,users.password,users.salt,profile.dname', '[["profile.email", "=", "' . $email . '"], "LIMIT 1"]');

		if($data->count() == 0){

			$this->_message = "Invalid Email";

			return false;

		}

		$newPassword = Neutron::randomChar(12);

		$data = $data->first();

		$newPasswordHash = Hash::make($newPassword, $data->salt);

		$this->_db->update($this->_table, $data->id, array( 'password' => $newPasswordHash ));

		Mail::sendChangePassword($email, $newPassword, $data->dname);

		$this->_message = "Your Password has been successfully reset. Please check your mail to view it";

		// $this->_data = $newPassword;

		return true;


	}

	public static function changePassword($oldPassword,$newPassword){

		if(!Hash::checkPassword($oldPassword, self::user()->password)){

			$this->_message = String::get('password.change.incorrect');

			return false;

		}

		Model::table(cg('auth.table'))->updateId(self::id(), [

			'password' => Hash::password($newPassword)

		]);

		$this->_message = String::get('password.change.sucessfull');

		return true;

	}


}
?>
