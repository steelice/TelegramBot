<?php

namespace RulezDev\TelegramBot;

/**
* Репрезентация объекта-чата
*/
class Chat
{
	
	protected 
		$id = 0,
		$type = 'unknown',
		$title = '',
		$username = '',
		$first_name = '',
		$last_name = '';


	function __construct(array $data)
	{
		if(empty($data['id']) || empty($data['type']))
			throw new \Exception('Invalid chat data');
			
		$this->id = $data['id'];
		$this->type = $data['type'];
		if(!empty($data['title']))
			$this->title = $data['title'];
		if(!empty($data['username']))
			$this->username = $data['username'];
		if(!empty($data['first_name']))
			$this->first_name = $data['first_name'];
		if(!empty($data['last_name']))
			$this->last_name = $data['last_name'];
	}

	public function getID()
	{
		return $this->id;
	}
}