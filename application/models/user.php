<?php

class User extends Eloquent
{
	public static $hidden = array('password');
	
	public function account()
	{
		return $this->has_one('Account');
	}

	public function set_password($password) 
	{
		$this->set_attribute('password', Hash::make($password));
	}
}