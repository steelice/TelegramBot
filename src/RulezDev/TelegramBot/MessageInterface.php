<?php

namespace RulezDev\TelegramBot;

/**
* Интерфейсный класс для сообщения. 
* Содержит несколько общих методов
*/
class MessageInterface
{
	protected
		$message_id = 0,
		$rawData = [],
		$type = 'unknown',
		$Chat = NULL,
		$User = NULL,
		$ReplyTo = NULL;

	protected function __construct(array $message)
	{
		$this->rawData = $message;
		

		$this->parse();
	}

	static public function create(array $message)
	{
		return new self($message);
	}

	public function getType()
	{
		return $this->type;
	}

	public function parse()
	{
		if(!empty($this->rawData['message_id']))
			$this->message_id = $this->rawData['message_id'];

		if(!empty($this->rawData['chat']))
			$this->Chat = new Chat($this->rawData['chat']);

		if(!empty($this->rawData['from']))
			$this->User = new User($this->rawData['from']);

		if(!empty($this->rawData['reply_to_message']))
			$this->ReplyTo = Message::parseInput($this->rawData['reply_to_message']);
	}

	public function getUser()
	{
		return $this->User;
	}

	public function getChat()
	{
		return $this->Chat;
	}

}