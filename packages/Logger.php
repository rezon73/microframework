<?php

class Logger
{
    public static function send($message)
    {
        $config = Config::me()->get('logs');
        if (!$config['enabled']) {
            return;
        }
    }

    protected static function extendMessage($jsonMessage)
    {
        $jsonMessage['microdatetime'] = Time::getMicroDateTime();
        $jsonMessage['pid'] = getmypid();

        return $jsonMessage;
    }
}