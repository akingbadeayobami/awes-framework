<?php

class Auth{

	private static $_check = null;

	private static $_user = null;

	private static $_id = null;

	public static function attempt($loginParameters,$rememberMe = true){

		$keys = array_keys($loginParameters);

		$model = Model::table(Config::get('auth.table'))->where($keys[0],$loginParameters[$keys[0]]);

		$user = $model->first();

		if(count($user) == 0){

			return false;

		}

		if(Hash::checkPassword($loginParameters[$keys[1]],$user->password)){

			$this->_message = String::get('auth.login.invalid');

			return false;

		}

		$model->update([

			'lastaccess' => time()

		]);

		Session::put(Config::get('session.name'), $user->id);

		if($rememberMe){

			$hash = Hash::unique();

			if(Model::table('users_session')->where('user_id',$user->id)->count()){

				Model::table('users_session')->create([

					'user_id' => $user->id,

					'hash' => $hash

				]);

			}else{

				Model::table('users_session')->where('user_id',$user->id)->update([

					'hash' => $hash

				]);

			}

			Cookie::put(Config::get('cookie.name'),$hash,Config::get('cookie/expiry'));

		}

	}

  public static function id(){

		if(self::$_id){

			return self::$_id;

		}

		if(Model::table(Config::get('auth.table'))->where('id', Session::get(Config::get('session.name'))->count() )){

			return self::$_id = Session::get(Config::get('session.name'));

		}

		return false;

  }

	public static function activated(){

		if(Auth::user()->activated == 0){

			self::logOut();

			return false;

		}

		return true;

	}

  public static function user(){

		if(self::$_user){

			return self::$_user;

		}

		if(Auth::id()){

			return self::$_user = Model::table(Config::get('auth.table'))->where('id', Auth::id() )->first();

		}

			return false;

	}

  public static function check(){

		if(self::$_check){

			return self::$_check;

		}

		if(Session::get(Config::get('session.name')) && self::id()){

			return self::$_check = true;

		}

		if(Cookie::exists(Config::get('cookie.name'))){

		  $hashCheck = Model::table('users_session')->where('hash',Cookie::get(Config::get('cookie.name')))->first();

			if($hashCheck){

				 Session::put(Config::get('session.name'), $hashCheck->user_id);

				 Model::table(Config::get('auth.table'))->updateId($hashCheck->user_id, [

					 'lastaccess' => time()

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

		Cookie::delete(Config::get('cookie.name'));

		Model::table('users_session')->where('user_id',Session::get(Config::get('session.name')))->first();

		Session::delete(Config::get('session.name'));

		$this->_message = String::get('auth.logout.valid');

		return true;

	}



	public function activateAccount(){

		$activatecode = Input::get('activatecode');

		$data = $this->_db->get($this->_table, 'matric,id', '[["activated", "=", "' . $activatecode . '"], "LIMIT 1"]');

		if($data->count() == 1){

			$data = $data->first();

			if($this->_db->update($this->_table, $data->id, ['activated' => 'true'])){

				$Profile = new Profile;

				$this->_data['name'] = $Profile->_getWhatFromMatric($data->matric,'dname');

				$this->_message = 'Your Account Has Been Verified Successfully';

				return true;

			}

		}

		$this->_message = 'Sorry You Account Was Not Successfully Validated';

		return false;

	}

	public function recoverPassword(){

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

		Model::table(Config::get('auth.table'))->updateId(self::id(), [

			'password' => Hash::password($newPassword)

		]);

		$this->_message = String::get('password.change.sucessfull');

		return true;

	}


}
?>
