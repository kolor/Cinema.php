<?php

class User_Controller extends Base_Controller 
{
	public $restful = true;

	public function get_index()
	{
		$user = new Services\Movie();
		var_dump($user);
	}

	#'''''''''''''''''''''''
	# registration (signup)
	#.......................

	public function get_signup()
	{
		return View::make('user.signup');
	}

	public function post_signup()
	{
		$input = Input::get();
		$rules = array(
			'username' => 'required|min:4|max:12|alpha_num|unique:users',
			'password' => 'required',
			'email'	   => 'required|unique:users|email',
			'captcha'  => 'coolcaptcha|required'
		);
		$messages = array(
			'coolcaptcha' => 'Wrong captcha provided'
		);
		$v = Validator::make($input, $rules, $messages);
		if ($v->fails()) {
			Input::flash('except', array('password'));
			return View::make('user.signup', array('errors'=>$v->errors));
		} else {
			$user = new User();
			$user->username = $input['username'];
			$user->email = $input['email'];
			$user->password = $input['password'];
			$user->save();
			Auth::login($user->id);
			return Redirect::to('account');
		}
	}

	#'''''''''''''''''''''''
	# authorization (login)
	#.......................

	public function get_login()
	{
		return View::make('user.login');
	}

	public function post_login()
	{
		$creds = Input::get();
		if (Auth::attempt($creds)) {
			return Redirect::to('account');
		} else {
			Input::flash('only', array('username'));
			return View::make('user.login')->with('error', 'Username and password do not match.');
		}
	}

	public function get_logout()
	{
		Auth::logout();
		return Redirect::to('home');
	}

	#'''''''''''''''''''''''
	# password recovery
	#.......................

	public function get_recover()
	{
		return View::make('user.recover');
	}

	public function post_recover()
	{
		$input = Input::get();
		$user = User::where('email','=',$input['email'])->first();
		if ($user) {
			$random = Str::random(32);
			$user->recover = $random;
			$user->save();
			// send string to email
			$url = URL::to_action('user@reset', array($user->id, $random));
			Message::to($input['email'])->from('recover@cinemator.com','Cinemator')
				->subject('Cinemator.com password recovery')
				->body('Please use this link to reset your password: '.$url)
				->send();
			return View::make('user.recover')->with('info','Confirmation has been sent to provided e-mail.');
		} else {
			Input::flash();
			return View::make('user.recover')->with('error','This e-mail was not found in database.');
		}
	}

	public function get_reset($id, $hash)
	{
		$user = User::find($id);
		if ($user->recover == $hash) {
			Auth::login($id);
			return Redirect::to('account/edit');
		} else {
			return Redirect::to('home');
		}
	}

}