<?php

namespace RulezDev\TelegramBot;

/**
* Работа с BotAPI телеграма
*/
class TelegramBotAPI
{
	protected $telegramURL = 'https://api.telegram.org/bot';
	protected $baseURL;

	protected $token;

	protected $logger = null;

	public function __construct($token)
	{
		$this->setToken($token);
	}

	/**
	 * Устанавливает функцию для записи лога
	 * @param callable $logger функция для ведения логов
	 */
	public function setLogger($logger)
	{
		$this->logger = $logger;
	}

	/**
	 * Записывает в лог с помощью установленного логгера
	 * @param  string $text Текст лога
	 * @return void       
	 */
	public function log($text)
	{
		if(!$this->logger || !is_callable($this->logger))
			return false;

		call_user_func($this->logger, $text);
	}

	/**
	 * Устанавливает secret token для коммуникаций
	 * @param string $token token
	 */
	public function setToken($token)
	{
		$this->token = trim($token);
		$this->baseURL = $this->telegramURL . $this->token.'/';
		return $this;
	}

	/**
	 * Отправляет POST-запрос на сервер телеграма
	 * @param  string $method метод
	 * @param  array  $params данные
	 * @return array         Ответ сервера, превращенный в массив
	 */
	protected function callMethod($method, array $params = [])
	{
		if(!$method = trim($method)) throw new Exception('Method not specified', 1);
		$ch = curl_init();

		curl_setopt($ch, CURLOPT_URL, $this->baseURL.$method);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 ); 

		$time = microtime(true);
		$server_output = curl_exec($ch);
		$end = microtime(true) - $time;
		if($end > 1)
		{
			$info = curl_getinfo($ch);
			$this->log('Slow curl: '.print_r($info, 1));
		}




		curl_close ($ch);

		if(!$server_output) return false;

		return json_decode(@$server_output, 1);
	}


	/**
	 * A simple method for testing your bot's auth token. 
	 * Requires no parameters. 
	 * @return array Basic information about the bot in form of a User object.
	 */
	public function getMe()
	{
		return $this->callMethod('getMe', array());
	}

	/**
	 * Use this method to receive incoming updates using long polling
	 * @param  int|null $offset Identifier of the first update to be returned. Must be greater by one than the highest among the identifiers of previously received updates.
	 * @param  int|null $limit  Limits the number of updates to be retrieved. Values between 1—100 are accepted. Defaults to 100
	 * @return array           An Array of Update objects is returned
	 */
	public function getUpdates(int $offset = NULL, int $limit = NULL)
	{
		$params = [];
		if($offset !== NULL) $params['offset'] = intval($offset);
		if($limit !== NULL && $limit > 0 && $limit <= 100) $params['limit'] = intval($limit);
		return $this->callMethod('getUpdates', $params);
	}


	/**
	 * Use this method to send text messages
	 * @param  int        $chat_id     Unique identifier for the message recipient
	 * @param  string     $text        Text of the message to be sent
	 * @param  int|null   $replyID     If the message is a reply, ID of the original message
	 * @param  array|null $replyMarkup Additional interface options. A JSON-serialized object for a custom reply keyboard, instructions to hide keyboard or to force a reply from the user.
	 * @return array                  On success, the sent Message is returned.
	 */
	public function sendMessage($chat_id, $text, $replyID = NULL, array $replyMarkup = NULL)
	{
		$params = ['chat_id' => $chat_id, 'text' => $text];
		if($replyID !== NULL) $params['reply_to_message_id'] = intval($replyID);
		if($replyMarkup !== NULL) $params['reply_markup'] = json_encode($replyMarkup);

		return $this->callMethod('sendMessage', $params);
	}

	/**
	 * Use this method to forward messages of any kind. 
	 * @param  int $chat_id      Unique identifier for the target chat or username of the target channel (in the format @channelusername)
	 * @param  int $from_chat_id Unique identifier for the chat where the original message was sent (or channel username in the format @channelusername)
	 * @param  int $message_id   Unique message identifier
	 * @return array               On success, the sent Message is returned.
	 */
	public function forwardMessage($chat_id, $from_chat_id, $message_id)
	{
		$params = ['chat_id' => $chat_id, 'from_chat_id' => $from_chat_id, 'message_id' => $message_id];

		return $this->callMethod('forwardMessage', $params);
	}

	/**
	 * Use this method to send photos.
	 * @param  int $chat_id     Unique identifier for the message recipient — User or GroupChat id
	 * @param  string $photo       local file path
	 * @param  string $caption     Photo caption
	 * @param  int $replyID     If the message is a reply, ID of the original message
	 * @param  array $replyMarkup Additional interface options.
	 * @return array              On success, the sent Message is returned.
	 */
	public function sendPhoto($chat_id, $photo, $caption = '', $replyID = NULL, $replyMarkup = NULL)
	{
		$params = ['chat_id' => $chat_id, 'photo' => '@'.$photo, 'caption' => trim($caption)];
		if($replyID !== NULL) $params['reply_to_message_id'] = intval($replyID);
		if($replyMarkup !== NULL) $params['reply_markup'] = $replyMarkup;

		return $this->callMethod('sendPhoto', $params);
	}

	/**
	 * Use this method to send voices.
	 * @param  int $chat_id     Unique identifier for the message recipient — User or GroupChat id
	 * @param  string $voice       local file path
	 * @param  string $duration     Duration in seconds
	 * @param  int $replyID     If the message is a reply, ID of the original message
	 * @param  array $replyMarkup Additional interface options.
	 * @return array              On success, the sent Message is returned.
	 */
	public function sendVoice($chat_id, $voice, $duration = 0, $replyID = NULL, $replyMarkup = NULL)
	{
		$params = ['chat_id' => $chat_id, 'voice' => '@'.$voice];
		if($duration) $params['duration'] = intval($duration);
		if($replyID !== NULL) $params['reply_to_message_id'] = intval($replyID);
		if($replyMarkup !== NULL) $params['reply_markup'] = $replyMarkup;

		return $this->callMethod('sendVoice', $params);
	}

	/**
	 * Use this method to send .webp stickers.
	 * @param  int $chat_id Unique identifier for the target chat or username of the target channel (in the format @channelusername)
	 * @param  array|string $sticker Sticker to send. You can either pass a file_id as String to resend a sticker that is already on the Telegram servers, or upload a new sticker using multipart/form-data.
	 * @param  int $replyID If the message is a reply, ID of the original message
	 * @return Message          On success, the sent Message is returned.
	 */
	public function sendSticker($chat_id, $sticker, $replyID = NULL)
	{
		if(is_array($sticker)) $sticker = json_encode($sticker);
		$params = ['chat_id' => $chat_id, 'sticker' => $sticker];
		if($replyID !== NULL) $params['reply_to_message_id'] = intval($replyID);

		return $this->callMethod('sendSticker', $params);
	}


	/**
	 * Use this method to specify a url and receive incoming updates via an outgoing webhook. 
	 * @param string $url HTTPS url to send updates to. Use an empty string to remove webhook integration
	 */
	public function setWebhook($url)
	{
		return $this->callMethod('setWebhook', array('url' => trim($url)));
	}

	/**
	 * Use this method when you need to tell the user that something is happening on the bot's side.
	 * @param  int $chat_id Unique identifier for the message recipient — User or GroupChat id
	 * @param  string $action  Type of action to broadcast. Choose one, depending on what the user is about to receive: typing for text messages, upload_photo for photos, record_video or upload_video for videos, record_audio or upload_audio for audio files, upload_document for general files, find_location for location data.
	 * @return void          
	 */
	public function sendChatAction($chat_id, $action)
	{
		return $this->callMethod('sendChatAction', array('chat_id' => $chat_id, 'action' => trim($action)));
	}

}