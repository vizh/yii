<?php
namespace application\components\console;

class BaseConsoleCommand extends \CConsoleCommand
{
    /**
     * @inheritdoc
     */
    protected function beforeAction($action, $params)
    {
        $_SERVER['SERVER_NAME'] = RUNETID_HOST;
        \Yii::setPathOfAlias(
            'webroot',
            \Yii::getPathOfAlias('webroot') . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'www'
        );

        return parent::beforeAction($action, $params);
    }

    /**
     * Prints a log message
     *
     * @param string $message The message
     * @param string $level Level of the message (for example CLogger::LEVEL_INFO, CLogger::LEVEL_WARNING)
     */
    protected function log($message, $level = null)
    {
        if (!$level) {
            $level = \CLogger::LEVEL_INFO;
        }

        \Yii::log($message, $level);
        echo $message . "\n";
    }

    /**
     * Prints an information message The message
     *
     * @param string $message
     */
    protected function info($message)
    {
        $this->log($message, \CLogger::LEVEL_INFO);
    }

    /**
     * Prints an error message
     *
     * @param string $message The message
     */
    protected function error($message)
    {
        $this->log($message, \CLogger::LEVEL_ERROR);
    }
}
