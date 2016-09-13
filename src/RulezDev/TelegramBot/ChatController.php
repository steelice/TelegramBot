<?php

namespace RulezDev\TelegramBot;

/**
* Хелпер-класс для взаимодействия с API
* Упрощает отправление в чат сообщений, фото, итд
*/
class ChatController
{
	protected
		$api = NULL,
		$msg = NULL,
		$parse_mode = false,
		$hide_keyboard = true;


	public function __construct(TelegramBotAPI $api, MessageInterface $msg)
	{
		$this->api = $api;
		$this->msg = $msg;
	}

	public function setParseMode($mode)
	{
		$this->parse_mode = $mode;
		return $this;
	}

	public function leftKeyboard()
	{
		$this->hide_keyboard = false;
		return $this;
	}

	public function say($text, $reply_to = null, array $reply_markup = null, array $additionalParams = [])
	{
		if($this->parse_mode && empty($additionalParams['parse_mode']))
			$additionalParams['parse_mode'] = $this->parse_mode;

		if(!$reply_markup && $this->hide_keyboard) $reply_markup = ['hide_keyboard' => true];

		$msg = $this->api->sendMessage($this->msg->getChat()->getID(), $text, $reply_to, $reply_markup, $additionalParams);
		if(empty($msg['ok'])) throw new \Exception("Error Processing Request: ".print_r($msg, true));
		
		return TextMessage::create($msg['result']);
	}

	public function getAPI()
	{
		return $this->api;
	}

	public function getMsg()
	{
		return $this->msg;
	}

	public function getMsgType()
	{
		return $this->msg->getType();
	}

	public function getChat()
	{
		return $this->msg->getChat();
	}

	public function getUser()
	{
		return $this->msg->getUser();
	}

	public function getMessageID()
	{
		return $this->msg->getID();
	}

	public function getID()
	{
		return $this->msg->getChat()->getID();
	}

	public function isGroup()
	{
		return !$this->msg->getChat()->isPrivate();
	}

	public function isPrivate()
	{
		return $this->msg->getChat()->isPrivate();
	}

	public function getText()
	{
		return trim($this->msg->getText());
	}

	public function getTextOnly()
	{
		return 
			trim(
			preg_replace('~\s{2,}~', ' ', 
			preg_replace('~[^\w\d\s]|_~u', '', 
				mb_strtolower($this->getText())
			)));
	}
}