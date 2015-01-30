<?php

class Account_Controller extends Base_Controller 
{
	public $restful = true;
	private $countries = array('United Kingdom','United States','Russia','France','Germany','Italy','Spain','Middle-East','South America','Asia');
	private $languages = array('English','Russian','Deutch','French','Spanish','Italiano');
	private $user = null;
	
	public function __construct()
	{
	    Asset::add('account.css','css/account.css');
		$this->filter('before','auth');
		$this->user = Auth::user();
	}

	#'''''''''''''''''''''''
	# profile editing
	#.......................

	public function get_index()
	{
		Asset::add('dropzone','js/vendor/dropzone.js');
		Asset::add('account','js/scripts/account.js');
		$data = array();
		$account = $this->user->account()->first();

		# session messages
		Session::has('info') ? $data['info'] = Session::get('info') :0;
		Session::has('error') ? $data['error'] = Session::get('error') :0;

		# account profile information
		if ($account) {
			$now = new DateTime();
			$int = $now->diff(new DateTime($account->dob));

			$data['account']['info'] = array(
				'Username' => $this->user->username,
				'Real Name' => $account->first_name.' '.$account->last_name,
				'Language' => $this->languages[$account->language],
				'Country' => $this->countries[$account->country],
				'City' => $account->city,
				'Age' => $int->y,
			);	

			$data['account']['bio'] = $account->bio;
			if (isset($account->avatar)) {
				$data['account']['pic'] = '/uploads/avatars/'.$this->user->id.'/'.$account->avatar;	
			} else {
				$data['account']['pic'] = 'http://www.gravatar.com/avatar/'.md5($this->user->email).'?d=retro&s=150';
			}
			
		}

		# favorite movies table
		$data['movies_table'] = array(
    		array('1', 'The Mist', '2007', '8.0 <small>(53000)</small>'),
    		array('2', 'The Godfather', '1981', '9.0 <small>(53000)</small>'),
    		array('3', 'Silent Hill', '2008', '6.2 <small>(53000)</small>'),
    		array('4', 'Resident Evil', '2007', '8.0 <small>(53000)</small>'),
    		array('5', 'The Green Mile', '2002', '8.0 <small>(53000)</small>'),
    	);
		
		return View::make('account.index', $data);
	}
	
	public function get_view($user_id)
	{
	    $user = User::find($user_id);
	    $account = $user->account()->first();

		# session messages
		Session::has('info') ? $data['info'] = Session::get('info') :0;
		Session::has('error') ? $data['error'] = Session::get('error') :0;

		# account profile information
		if ($account) {
			$now = new DateTime();
			$int = $now->diff(new DateTime($account->dob));

			$data['account']['info'] = array(
				'Username' => $user->username,
				'Real Name' => $account->first_name.' '.$account->last_name,
				'Language' => $this->languages[$account->language],
				'Country' => $this->countries[$account->country],
				'City' => $account->city,
				'Age' => $int->y,
			);	

			$data['account']['bio'] = $account->bio;
			if (isset($account->avatar)) {
				$data['account']['pic'] = '/uploads/avatars/'.$user->id.'/'.$account->avatar;	
			} else {
				//$data['acc']['pic'] = "http://placehold.it/140x140";
				$data['account']['pic'] = 'http://www.gravatar.com/avatar/'.md5($this->user->email).'?d=retro&s=150';
			}
			
		}

		# favorite movies table
		$data['movies_table'] = array(
    		array('1', 'The Mist', '2007', '8.0 <small>(53000)</small>'),
    		array('2', 'The Godfather', '1981', '9.0 <small>(53000)</small>'),
    		array('3', 'Silent Hill', '2008', '6.2 <small>(53000)</small>'),
    		array('4', 'Resident Evil', '2007', '8.0 <small>(53000)</small>'),
    		array('5', 'The Green Mile', '2002', '8.0 <small>(53000)</small>'),
    	);
		
		return View::make('account.view', $data);
	}

	public function get_edit()
	{
		$user = Auth::user();
		$data = array();
		$account = $user->account()->first();
		if ($account) {
			$data['account'] = $account;
		} else {
			$data['account'] = new Account();
		}
		$data['languages'] = $this->languages;
		$data['countries'] = $this->countries;
		return View::make('account.edit', $data);
	}

	public function post_edit()
	{
		$input = Input::get();
		$rules = array(
			'dob'	   => 'before:2000-01-01',
		);
		$v = Validator::make($input, $rules);
		if ($v->fails()) {
			$account = json_decode(json_encode($input), FALSE);
			return View::make('account.edit', array(
				'errors'=>$v->errors, 
				'account'=>$account,
				'countries'=>$this->countries,
				'languages'=>$this->languages
			));
		} else {
			$user = Auth::user();
			$account = $user->account()->first();
			if (!$account) {
				$account = new Account();
				$account->user_id = $user->id;
			}
			$account->fill($input);
			$account->save();
			Session::flash('info','Your profile has been saved.');
			return Redirect::to('account');
		}
	}

	public function get_security()
	{
		return View::make('account.security');
	}

	public function post_security()
	{
		$input = Input::get();
		$user = Auth::user();
		$check = User::where('email','=',$input['email'])->where('id','=',$user->id)->first();
		if ($check) {
			$user->password = $input['password'];
			$user->save();
			Session::flash('info','Password has been changed.');
			return Redirect::to('account');
		} else {
			return View::make('account.security')->with('error','Incorrect e-mail provided.');		
		}

	}
	
	public function post_avatar() 
	{
		$user = Auth::user();
		$input = Input::all();
		$rules = array(
		    'file' => 'image|max:3000',
		);

		$validation = Validator::make($input, $rules);

		if ($validation->fails())
		{
			return Response::make($validation->errors->first(), 400);
		}

		$file = Input::file('file');

        $extension = File::extension($file['name']);
        $directory = path('public').'/uploads/avatars/'.$user->id;
        $filename = sha1(time()).".{$extension}";
        $upload_success = Input::upload('file', $directory, $filename);

        if( $upload_success ) {
        	$account = $user->account()->first();
        	$account->avatar = $filename;
        	$account->save();
        	return Response::json("OK", 200);
        } else {
        	return Response::json('NOK', 400);
        }
	}

	#'''''''''''''''''''''''
	# preferences
	#.......................

	public function get_preferences()
	{
		return View::make('account.preferences');
	}

	public function post_preferences()
	{

	}

	public function get_notifications()
	{
		return View::make('account.notifications');
	}

	public function post_notifications()
	{

	}

	public function get_sharing()
	{
		return View::make('account.sharing');

	}

	public function post_sharing()
	{

	}

}