<?php

class Account_Controller extends Base_Controller 
{
	public $restful = true;
	private $countries = array('United Kingdom','United States','Russia','France','Germany','Italy','Spain','Middle-East','South America','Asia');
	private $languages = array('English','Russian','Deutch','French','Spanish','Italiano');

	public function __construct()
	{
		$this->filter('before','auth');

		//Event::listen('laravel.query', function($sql) {var_dump($sql);});
	}

	#'''''''''''''''''''''''
	# profile editing
	#.......................

	public function get_index()
	{
		$data = array();
		$user = Auth::user();	
		$acc = $user->account()->first();

		# session messages
		Session::has('info') ? $data['info'] = Session::get('info') :0;
		Session::has('error') ? $data['error'] = Session::get('error') :0;

		# account profile information
		if ($acc) {
			$now = new DateTime();
			$int = $now->diff(new DateTime($acc->dob));

			$data['acc']['info'] = array(
				'Username' => $user->username,
				'Real Name' => $acc->first_name.' '.$acc->last_name,
				'Country' => $this->countries[$acc->country],
				'City' => $acc->city,
				'Language' => $this->languages[$acc->language],
				'Age' => $int->y
			);	

			$data['acc']['bio'] = $acc->bio;
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

	public function get_edit()
	{
		$user = Auth::user();
		$data = array();
		$acc = $user->account()->first();
		if ($acc) {
			$data['account'] = $acc;
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
			$acc = json_decode(json_encode($input), FALSE);
			return View::make('account.edit', array(
				'errors'=>$v->errors, 
				'account'=>$acc,
				'countries'=>$this->countries,
				'languages'=>$this->languages
			));
		} else {
			$user = Auth::user();
			$acc = $user->account()->first();
			if (!$acc) {
				$acc = new Account();
				$acc->user_id = $user->id;
			}
			$acc->fill($input);
			$acc->save();
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

	#'''''''''''''''''''''''
	# other profile related
	#.......................

	public function get_inbox()
	{
		Asset::add('chat','js/classes/chat.js');
		Asset::add('inbox','js/scripts/inbox.js');
		$data = array();
		$data['friends'] = array(
			array('name'=>'Pavel Rizik','id'=>'2','nick'=>'owl'),
			array('name'=>'Jelena Sendze','id'=>'3','nick'=>'delight'),
			array('name'=>'Anton Melbardis','id'=>'4','nick'=>'ninja'),
			array('name'=>'Aleksej Gudilin','id'=>'5','nick'=>'fmx'),
			array('name'=>'Jurij Molcanov','id'=>'6','nick'=>'jurik'),
			array('name'=>'Artur Pirozkov','id'=>'7','nick'=>'und')
		);
		return View::make('account.inbox', $data);
	}

	# page with list of contacts
	public function get_friends()
	{

	}

	# add, delete, edit contact list
	public function post_friends()
	{
		return View::make('account.contacts');
	}

	public function get_wall()
	{

	}

	public function post_wall()
	{

	}

	# get conversation with $friend (ajax)
	public function get_message($friend, $since)
	{
		$user = Auth::user();
		$data = Chat::retrieve($user->id, $friend, $since);		
		return Response::json($data);
	}

	# add message to conversation with $user
	public function post_message()
	{
		$input = Input::get();
		$user = Auth::user();
		$msg = new Chat();
		$msg->from = $user->id;
		$msg->to = $input['to'];
		$msg->text = $input['txt'];
		$msg->save();
		$data = Chat::retrieve($user->id, $input['to'], $input['last']);
		return Response::json($data);
	}

}