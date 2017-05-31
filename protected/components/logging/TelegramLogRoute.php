<?php

namespace application\components\logging;

class TelegramLogRoute extends \CLogRoute
{
    /**
     * Processes log messages and sends them to specific destination.
     * Derived child classes must implement this method.
     *
     * @param array $logs list of messages. Each array element represents one message
     * with the following structure:
     * array(
     *   [0] => message (string)
     *   [1] => level (string)
     *   [2] => category (string)
     *   [3] => timestamp (float, obtained by microtime(true));
     */
    protected function processLogs($logs)
    {
        foreach ($logs as $log) {
            (new \GuzzleHttp\Client())->get('https://api.telegram.org/bot217593085:AAG-Px7tznYlD76KL18aJa0rV8Ceh1BMiio/sendMessage', [
                'query' => [
                    'chat_id' => -1001073743954,
                    'parse_mode' => 'HTML',
                    'text' => sprintf("<b>%s ↬ %s</b>\n%s",
                        $log[2],
                        $log[1],
                        array_shift(explode("\n", $log[0]))
                    )
                ]
            ]);
        }
    }
}