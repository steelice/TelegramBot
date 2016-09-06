<?php

namespace RulezDev\TelegramBot;

class Message
{
	static public function parseInput($m)
	{

		if(empty($m['message_id'])) return NULL;
		if(!empty($m['text'])) {
			$command = Command::create($m);
			return $command ? $command : TextMessage::create($m);
		}
	}
}