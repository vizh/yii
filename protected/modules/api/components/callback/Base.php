<?php
namespace api\components\callback;

class Base
{
    protected $account;

    public function __construct(\api\models\Account $account)
    {
        $this->account = $account;
    }

    /**
     * @var \api\models\CallbackLog
     */
    protected $log;

    /**
     * @param \event\models\Event $event
     * @return \api\components\callback\Base
     */
    public static function getCallback(\event\models\Event $event)
    {
        /** @var \api\models\Account $account */
        $account = \api\models\Account::model()->byEventId($event->Id)->find();
        if ($account == null)
            return null;

        $class = \Yii::getExistClass('\api\components\callback', 'Account' . ucfirst($event->IdName));
        if ($class == null)
            $class = \Yii::getExistClass('\api\components\callback', 'Account' . ucfirst($account->Role), 'Base');
        return new $class($account);
    }

    /**
     * @return string|null
     */
    protected function getUrlRegisterOnEvent()
    {
        return null;
    }

    public function registerOnEvent(\user\models\User $user, \event\models\Role $role)
    {
        $url = $this->getUrlRegisterOnEvent();
        if ($url !== null) {

        }
    }


    /**
     * @param string $url
     * @param array $params
     * @param bool $isPost
     *
     * @return string
     */
    protected function sendMessage($url, $params, $isPost = false)
    {
        $this->log = new \api\models\CallbackLog();
        $this->log->AccountId = $this->account->Id;
        $this->log->Url = $url;
        $this->log->Params = json_encode($params, JSON_UNESCAPED_UNICODE);

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 3);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        if ($isPost) {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params);
        } else {
            $params = http_build_query($params);
            $url .= (strpos($url, '?') === false ? '?' : '&') . $params;
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        $result = curl_exec($curl);

        $errno = curl_errno($curl);
        $errmsg = curl_error($curl);
        curl_close($curl);
        if ($errno != 0) {
            $this->log->ErrorCode = 100;
            $this->log->ErrorMessage = $this->parseErrorMessage(100, [$errno, $errmsg]);
            return null;
        }
        $this->log->Response = $result;

        $this->log->save();
        return $result;
    }

    /**
     * @param $code
     *
     * @return string|null
     */
    protected function getErrorMessage($code)
    {
        $errors = [
            100 => 'Ошибка при вызове curl. Номер ошибки: %s. Сообщение: %s'
        ];
        return isset($errors[$code]) ? $errors[$code] : null;
    }

    protected function parseErrorMessage($code, $params = [])
    {
        $message = $this->getErrorMessage($code);
        
        return $message != null
            ? vsprintf($message, $params)
            : null;
    }

    protected function logError($code, $params)
    {
        $log = new \api\models\CallbackLog();
        $log->AccountId = $this->account->Id;
        $log->ErrorCode = $code;
        $log->ErrorMessage = $this->parseErrorMessage($code, $params);
        $log->save();
    }
}