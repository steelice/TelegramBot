<?php

namespace RulezDev\TelegramBot;

/**
* Репрезентация объекта-юзера
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

	/**
	 * Возвращает ID юзера
	 * @return int ID
	 */
	public function getID()
	{
		return $this->id;
	}

	/**
	 * Возвращает @-юзернейм юзера
	 * @return string 
	 */
	public function getUsername()
	{
		return $this->username;
	}

	/**
	 * First Name
	 * @return string 
	 */
	public function getFirstName()
	{
		return $this->first_name;
	}

	/**
	 * Last Name
	 * @return string 
	 */
	public function getLastName()
	{
		return $this->last_name;
	}

	/**
	 * Last Name + First Name, trimmed spaces
	 * @return string 
	 */
	public function getFullname()
	{
		return trim($this->first_name.' '.$this->last_name);
	}
}