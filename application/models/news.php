<?php

class News extends Eloquent
{
	public static $table = 'news';
	
	public function account()
	{
		return $this->has_one('Account');
	}

	public function get_date() 
	{
		return date('M j, Y', strtotime($this->get_attribute('created_at')));
	}
}