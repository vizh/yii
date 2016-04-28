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
}
