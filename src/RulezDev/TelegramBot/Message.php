<?php

namespace RulezDev\TelegramBot;

class Message
{

    const TYPE_TEXT = 'text';

	/**
	 * Фабрикует класс, обрабатывающий сообщение
	 * @param  array $m Сообщение на вход
	 * @return MessageInterface    Класс, ответственный за данный тип сообщения
	 */
	static public function parseInput($m)
	{
        if(!is_array($m) && is_string($m)) {
            $m = @json_decode($m, true);
        }

		if(empty($m['message'])) return NULL;
		if(!empty($m['message']['text'])) {
			return  TextMessage::create($m);
		}elseif(!empty($m['message']['location']))
		{
			return Location::create($m);
		}

		return null;
	}
}