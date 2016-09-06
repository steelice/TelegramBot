<?php

namespace RulezDev\TelegramBot;

/**
* Текстовое сообщение
*/
class TextMessage extends MessageInterface
{
	protected
		$type = 'text',
		$text;


	public function parse()
	{
		parent::parse();

		$this->text = trim($this->rawData['text']);
	}
	

	public function getText()
	{
		return $this->text;
	}
}