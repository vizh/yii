<?php

namespace api\components;

use api\models\Account;
use event\models\Event;
use Yii;

class WebUser extends \CWebUser
{
    private static $instance;

    /**
     * @static
     * @return WebUser
     */
    public static function Instance()
    {
        if (self::$instance === null) {
            self::$instance = new WebUser();
        }

        return self::$instance;
    }

    /**
     * @var Account|null
     */
    private $account;

    /**
     * @return Account
     * @throws Exception
     */
    public function getAccount()
    {
        if ($this->account === null) {
            $request = Yii::app()->getRequest();

            $key = !empty($_SERVER['HTTP_APIKEY']) ? $_SERVER['HTTP_APIKEY'] : null;
            $hash = !empty($_SERVER['HTTP_HASH']) ? $_SERVER['HTTP_HASH'] : null;
            $timestamp = !empty($_SERVER['HTTP_TIMESTAMP']) ? $_SERVER['HTTP_TIMESTAMP'] : null;

            $key = $request->getParam('ApiKey', $key);
            $hash = $request->getParam('Hash', $hash);
            $timestamp = $request->getParam('Timestamp', $timestamp);

            $account = Yii::app()
                ->getCache()
                ->get("$key,$hash,$timestamp");

            if ($account === false) {
                $account = Account::model()
                    ->byKey($key)
                    ->with('Event', 'Ips')
                    ->find();

                if ($account === null) {
                    throw new Exception(101);
                }

                if ($account->checkHash($hash, $timestamp) === false) {
                    throw new Exception(102);
                }

                if ($account->Blocked) {
                    throw new Exception(105);
                }

                if ($account->checkIp($request->getUserHostAddress()) === false) {
                    throw new Exception(103, [$key, $request->getUserHostAddress()]);
                }

                Yii::app()
                    ->getCache()
                    ->set("$key,$hash,$timestamp", $account, 30);
            }

            // Предоставляем возможность иметь api-аккаунты с динамической привязкой к мероприятию
            // Важно понимать, что есть единственный метод-исключение: event/list, для вызова которого
            // мы не можем знать конкретный EventId
            if ($account->EventId === null && !in_array($request->pathInfo, ['event/list', 'user/auth'])) {
                $account->EventId = $request->getParam('EventId');
                // Параметр EventId обязателен для отправки запроса из под мультиаккаунта
                /** @noinspection NotOptimalIfConditionsInspection */
                if ($account->EventId === null) {
                    throw new Exception(109, ['EventId']);
                }
                // В случае мультиаккаунтов, связи в моделях работать не будут. Помогаем им.
                $account->Event = Event::model()->findByPk($account->EventId);
            }

            $this->account = $account;
        }

        return $this->account;
    }

    public function resetAccount()
    {
        $this->account = null;
    }

    /**
     * @return null|string
     */
    public function getRole()
    {
        if ($this->account !== null || $this->getAccount() !== null) {
            return $this->account->Role;
        }

        return null;
    }

    protected $_access = [];

    public function checkAccess($operation, $params = [], $allowCaching = true)
    {
        if ($allowCaching && $params === [] && isset($this->_access[$operation])) {
            return $this->_access[$operation];
        } else {
            return $this->_access[$operation] = Yii::app()->apiAuthManager->checkAccess($operation, $this->getId(),
                $params);
        }
    }

    public function getIsGuest()
    {
        return $this->account === null
            && $this->getAccount() === null;
    }

    public function getId()
    {
        return !$this->getIsGuest() ? $this->getAccount()->Id : null;
    }

    public function loginRequired()
    {
        try {
            parent::loginRequired();
        } catch (\CHttpException $e) {
            throw new Exception(100, [$e->getMessage()]);
        }
    }
}