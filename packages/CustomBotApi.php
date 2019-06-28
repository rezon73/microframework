<?php

class CustomBotApi extends \TelegramBot\Api\BotApi
{
    /**
     * Use this method to send text messages. On success, the sent \TelegramBot\Api\Types\Message is returned.
     *
     * @param int|string $chatId
     * @param string $text
     * @param string|null $parseMode
     * @param bool $disablePreview
     * @param int|null $replyToMessageId
     * @param Types\ReplyKeyboardMarkup|Types\ReplyKeyboardHide|Types\ForceReply|null $replyMarkup
     * @param bool $disableNotification
     *
     * @return \TelegramBot\Api\Types\Message
     * @throws \TelegramBot\Api\InvalidArgumentException
     * @throws \TelegramBot\Api\Exception
     */
    public function sendMessage(
        $chatId,
        $text,
        $parseMode = null,
        $disablePreview = false,
        $replyToMessageId = null,
        $replyMarkup = null,
        $disableNotification = false
    ) {
        $messages = [];
        $messageMaxLength = Config::me()->get('telegram')['messageMaxLength'];
        if (mb_strlen($text) > $messageMaxLength) {
            $messages = mb_str_split($text, $messageMaxLength);
        }
        else {
            $messages[] = $text;
        }

        $lastMessage = new \TelegramBot\Api\Types\Message;
        foreach($messages as $message) {
            $lastMessage = \TelegramBot\Api\Types\Message::fromResponse($this->call('sendMessage', [
                'chat_id'                  => $chatId,
                'text'                     => $message,
                'parse_mode'               => $parseMode,
                'disable_web_page_preview' => $disablePreview,
                'reply_to_message_id'      => (int)$replyToMessageId,
                'reply_markup'             => is_null($replyMarkup) ? $replyMarkup : $replyMarkup->toJson(),
                'disable_notification'     => (bool)$disableNotification,
            ]));
        }

        return $lastMessage;
    }
}