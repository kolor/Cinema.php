<?php

class Friend extends Eloquent
{
	public static $table = 'friends';
	
	public function user()
	{
		return $this->belongs_to('User');
	}
	
	public function friend()
	{
        return $this->belongs_to('User', 'friend');
        //return User::where('user_id','=',$this->friend);
	}


}