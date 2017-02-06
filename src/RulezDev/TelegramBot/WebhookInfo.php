<?php

namespace RulezDev\TelegramBot;

/**
 * Result of TelegramBotAPI::setWebhook()
 *
 * @property string $last_error_message
 * @property string $url
 * @property bool $has_custom_certificate
 * @property int $pending_update_count
 * @property int $last_error_date
 * @property int $max_connections
 * @property string[] $allowed_updates
 */
class WebhookInfo extends StdGetterHelper
{

}