<?php

namespace RulezDev\TelegramBot;

/**
* Текстовое сообщение
*/
class TextMessage extends MessageInterface
{
	protected

		$type = Message::TYPE_TEXT,
        /**
         * @var string
         */
		$text,
        /**
         * @var Command
         */
	    $command = null;


	public function parse()
	{
		parent::parse();

		$this->text = trim($this->rawData['text']);
		$this->command = Command::create($this->rawData);
	}
	
	/**
	 * Возвращает текст сообщения
	 * @return string текст сообщения
	 */
	public function getText()
	{
		return $this->text;
	}

    /**
     * @return Command
     */
    public function getCommand()
    {
        return $this->command;
	}
}