# TelegramBot
Interface and some usefult classes to working with Telegram Bot API

## Example
```php
$th = new RulezDev\TelegramBot\TelegramBotAPI('YOUR_TELEGRAM_KEY');
$th->sendMessage($userOrChatID, $text, $replyToID, $replyMarkup, $additionalParameters);
$th->sendPhoto($userOrChatID, $pathToFile, $caption, $replyToID, $replyMarkup, $additionalParameters);
$th->editMessage($userOrChatID, $messageID, $newText, $replyMarkup, $additionalParameters);
```

