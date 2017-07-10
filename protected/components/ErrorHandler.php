<?php
namespace application\components;

use Raven_Client;
use Yii;

class ErrorHandler extends \CErrorHandler
{
    /** @var Raven_Client */
    protected $ravenClient;

    /**
     * @return Raven_Client
     */
    public function getRavenClient()
    {
        if ($this->ravenClient === null) {
            $this->ravenClient = new Raven_Client($_ENV['SENTRY_DSN'], [
                'site' => isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : $_SERVER['SERVER_NAME'],
                'environment' => YII_DEBUG ? 'development' : 'production',
                'tags' => [
                    'php' => PHP_VERSION,
                    'yii' => Yii::getVersion()
                ]
            ]);

            $webuser = Yii::app()->getUser();

            if (false === Yii::app()->getUser()->getIsGuest()) {
                $user = Yii::app()->getUser()->getCurrentUser();
                $this->ravenClient->user_context([
                    'id' => $user->RunetId,
                    'Email' => $user->Email
                ]);
            } elseif (null !== $account = $webuser->getCurrentAccount()) {
                $this->ravenClient->user_context([
                    'id' => $account->Key,
                    'EventID' => $account->EventId,
                    'EventName' => $account->Event->IdName,
                    'AccountID' => $account->Id
                ]);
            }
        }

        return $this->ravenClient;
    }

    protected function handleException($exception)
    {
        // Перенаправляем сообщение об ошибке в Sentry
        $this->getRavenClient()->captureException($exception);
        // Дальнейшая обработка - штатная
        parent::handleException($exception);
    }

    protected function handleError($event)
    {
        // Перенаправляем сообщение об ошибке в Sentry
        $this->getRavenClient()->captureMessage($event->message);
        // Дальнейшая обработка - штатная
        parent::handleError($event);
    }
}