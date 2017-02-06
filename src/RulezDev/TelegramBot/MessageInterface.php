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
		$update_id = 0,
		$rawData = [],
		$type = 'unknown',
		$Chat = NULL,
		$User = NULL,
		$ReplyTo = NULL;

	protected function __construct(array $message)
	{
	    if (empty($message['message'])) throw new \Exception('Wrong message');
		$this->rawData = $message['message'];
		$this->update_id = $message['update_id'];
		

		$this->parse();
	}

	static public function create(array $message)
	{
		return new static($message);
	}

	/**
	 * Возвращает тип сообщения
	 * @return string [description]
	 */
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

	public function getID()
	{
		return $this->message_id;
	}

	public function getRaw()
	{
		return $this->rawData;
	}

	public function getText()
	{
		if(isset($this->rawData['text']))
			return $this->rawData['text'];

		return null;
	}

}