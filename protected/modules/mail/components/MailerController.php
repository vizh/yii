<?php
namespace mail\components;

abstract class MailerController extends \application\components\controllers\AdminMainController
{
    /**
     * @return Mailer
     */
    abstract protected function getMailer();

    /**
     * @return int
     */
    abstract protected function getStepCount();

    private $file = null;

    protected function getLogResource()
    {
        if ($this->file === null) {
            $logPath = \Yii::getPathOfAlias('mail.data');
            $this->file = fopen($logPath.DIRECTORY_SEPARATOR.$this->getTemplateName().'.log', "a+");
        }

        return $this->file;
    }

    protected function addLogMessage($message)
    {
        fwrite($this->getLogResource(), $message."\r\n");
    }

    protected function afterAction($action)
    {
        if ($this->file !== null) {
            fclose($this->file);
        }
        parent::afterAction($action);
    }
}