<?php

class Chat extends Eloquent
{
	public static $table = 'messages';

	public static function retrieve($user, $friend, $since) {
		if (is_numeric($since)) {
		    // get all messages since <$since> where $user>$friend and $friend>$user
			$res = 	self::where(function($q) use ($user, $friend, $since) { 
							$q->where_from($user)->where_to($friend)->where('id','>',$since);
						})->or_where(function($q) use ($user, $friend, $since) { 
							$q->where_from($friend)->where_to($user)->where('id','>',$since);
						})->order_by('id','asc')->take(50)->get();
		} else {
			switch($since) {
				case 'last':
					$res = 	self::where(function($q) use ($user, $friend) { 
									$q->where_from($user)->where_to($friend);
								})->or_where(function($q) use ($user, $friend) { 
									$q->where_from($friend)->where_to($user);
								})->order_by('id','asc')->take(20)->get();
					break;
				case 'all':
					$res =  self::where(function($q) use ($user, $friend) { 
									$q->where_from($user)->where_to($friend);
								})->or_where(function($q) use ($user, $friend) { 
									$q->where_from($friend)->where_to($user);
								})->order_by('id','desc')->take(100)->get();
					break;
			}
		}

		$data = array();
		foreach ($res as $v) {
			$d = $v->attributes;
			$d['class'] = ($d['from'] == $user) ? 'me' : 'he';
			$data[] = $d;
		}

		$last = (count($data) > 0) ? $data[0]['id'] : 0;
	
		return array(
			'data' => $data,
			'last' => $last
		);
	}

}