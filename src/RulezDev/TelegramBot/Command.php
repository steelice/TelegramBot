<?php

namespace RulezDev\TelegramBot;

/**
* Интерпретатор команды для бота
*/
class Command extends TextMessage
{
	protected
		$command = '',
		$to = '',
		$arguments = '',
		$type = 'command';

	protected function __construct(array $message)
	{
		parent::__construct($message);
		$this->command = $message['rulezdev:custom']['command'];
		$this->to = $message['rulezdev:custom']['to'];
		$this->arguments = $message['rulezdev:custom']['arguments'];
	}

	static public function create(array $message)
	{
		if(empty($message['text'])) return false;
		if(!preg_match('~^/([a-z0-9_]+)(@[a-z0-9_]+)?([\\s#:.]+(.*))?$~i', $message['text'], $match))
			return false;


		$message['rulezdev:custom'] = [
			'command' => trim(strtolower($match[1])),
			'to' => empty($match[2]) ? '' : self::simpleBotName($match[2]),
			'arguments' => empty($match[4]) ? '' : trim($match[4])
		];
		
		return new self($message);
	}

	/**
	 * Упрощает имя бота до простейшего вида
	 * Удобно для сравнения
	 * @param  string $name Исходное имя бота
	 * @return string       Упрощенное имя бота
	 */
	static public function simpleBotName($name)
	{
		return trim(strtolower($name), ' @');
	}

	public function getCommand()
	{
		return $this->command;
	}

	public function getTo()
	{
		return $this->to;
	}

	public function getArguments()
	{
		return $this->arguments;
	}

	public function getArgs()
	{
		return $this->getArguments();
	}

	/**
	 * Возвращает true, если данная команда предназначена боту, 
	 * имя которого указано первым аргументом
	 * @param  string  $me Имя бота
	 * @return boolean     Моя ли команда
	 */
	public function isMy($me)
	{
		if(!$this->to) return true;

		return $this->simpleBotName($me) == $this->to;
	}
}