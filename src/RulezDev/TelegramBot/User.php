<?php

namespace RulezDev\TelegramBot;

/**
* Репрезентация объекта-чата
*/
class User
{
	
	protected 
		$id = 0,
		$username = '',
		$first_name = '',
		$last_name = '';


	function __construct(array $data)
	{
		if(empty($data['id']) || empty($data['first_name']))
			throw new \Exception('Invalid user data');
			
		$this->id = $data['id'];
		$this->first_name = $data['first_name'];

		if(!empty($data['username']))
			$this->username = $data['username'];
		if(!empty($data['last_name']))
			$this->last_name = $data['last_name'];
	}

	public function getID()
	{
		return $this->id;
	}
}