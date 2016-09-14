<?php

namespace RulezDev\TelegramBot;

/**
* Интерпретатор команды для бота
*/
class Location extends MessageInterface
{
	protected
		$lat,
		$lng,
		$type = 'location';

	protected function __construct(array $message)
	{
		parent::__construct($message);
		$this->lat = $message['location']['latitude'];
		$this->lng = $message['location']['longitude'];
	}

	public function getLat()
	{
		return $this->lat;
	}

	public function getLng()
	{
		return $this->lng;
	}

	
}