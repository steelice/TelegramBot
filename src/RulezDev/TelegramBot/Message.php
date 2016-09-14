<?php

namespace RulezDev\TelegramBot;

class Message
{
	/**
	 * Фабрикует класс, обрабатывающий сообщение
	 * @param  array $m Сообщение на вход
	 * @return object    Класс, ответственный за данный тип сообщения
	 */
	static public function parseInput($m)
	{

		if(empty($m['message_id'])) return NULL;
		if(!empty($m['text'])) {
			$command = Command::create($m);
			return $command ? $command : TextMessage::create($m);
		}elseif(!empty($m['location']))
		{
			return Location::create($m);
		}
	}
}