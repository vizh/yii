<?php
namespace api\components;

class Controller extends \application\components\controllers\BaseController
{
    const MaxResult = 200;

    protected $result;

    public function actions()
    {
        return $this->getVersioningActions();
    }

    /**
     * @return array
     */
    protected function getVersioningActions()
    {
        $path = \Yii::getPathOfAlias('api.controllers.'.$this->getId());
        $result = [];

        // toDo: Вообще, - это не правильно считывать содержимое директории на каждом хите.
        foreach (scandir($path) as $file) {
            if (preg_match('/((\w*?)Action(\d*?)).php$/i', $file, $matches) === 1) {
                //$matches[3] - дата новой версии action
                //todo: даполнить метод версионностью
                $key = lcfirst($matches[2]);
                $val = '\\api\\controllers\\'.$this->getId().'\\'.$matches[1];
                $result[$key] = $val;

                if ($key !== strtolower($key)) {
                    $key = strtolower($key);
                    $result[$key] = $val;
                }
            }
        }

        return $result;
    }

    /**
     * @param mixed $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @param \CAction $action
     *
     * @return bool
     */
    protected function beforeAction($action)
    {
        if (YII_DEBUG === false) {
            \Yii::app()->disableOutputLoggers();
        }

        return parent::beforeAction($action);
    }

    /**
     * @param \CAction $action
     */
    public function afterAction($action)
    {
        echo json_encode($this->result, JSON_UNESCAPED_UNICODE);
        $this->createLog();
    }

    /**
     * @param string|null $errorCode
     * @param string|null $errorMessage
     * @return \api\models\Log
     */
    public function createLog($errorCode = null, $errorMessage = null)
    {
        $executionTime = \Yii::getLogger()->getExecutionTime();

        $log = new \api\models\Log();
        $log->AccountId = $this->getAccount() !== null ? $this->getAccount()->Id : null;
        $log->Route = $this->getId().'.'.$this->getAction()->getId();
        $log->Params = json_encode($_REQUEST, JSON_UNESCAPED_UNICODE);
        $log->FullTime = $executionTime;
        $log->DbTime = null;

        if ($errorCode !== null) {
            $log->ErrorCode = $errorCode;
        }

        if ($errorMessage !== null) {
            $log->ErrorMessage = $errorMessage;
        }

        $log->save();

        return $log;
    }

    public function filters()
    {
        $filters = parent::filters();

        return array_merge(
            $filters,
            [
                'accessControl',
                'setLanguage'
            ]
        );
    }

    protected function setHeaders()
    {
        header('Content-type: text/json; charset=utf-8');
    }

    /** @var AccessControlFilter */
    private $accessFilter;

    public function getAccessFilter()
    {
        if ($this->accessFilter === null) {
            $this->accessFilter = new AccessControlFilter();
            $this->accessFilter->setRules($this->accessRules());
        }

        return $this->accessFilter;
    }

    public function filterAccessControl($filterChain)
    {
        $this->getAccessFilter()->filter($filterChain);
    }

    public function accessRules()
    {
        /** @noinspection PhpIncludeInspection */
        return require \Yii::getPathOfAlias('api.rules').'.php';
    }

    /**
     * @return \api\models\Account
     */
    public function getAccount()
    {
        return \api\components\WebUser::Instance()->getAccount();
    }

    private $suffixLength = 4;

    public function getPageToken($offset)
    {
        $prefix = substr(base64_encode($this->getId().$this->getAction()->getId()), 0, $this->suffixLength);

        return $prefix.base64_encode($offset);
    }

    /**
     * @param string $token
     * @throws Exception
     * @return int
     */
    public function parsePageToken($token)
    {
        if (strlen($token) < $this->suffixLength + 1) {
            throw new Exception(111);
        }

        $token = substr($token, $this->suffixLength);

        $result = (int)base64_decode($token);
        if ($result === 0) {
            throw new Exception(111);
        }

        return $result;
    }

    /**
     * @param \CFilterChain $filterChain
     */
    public function filterSetLanguage($filterChain)
    {
        $this->setLanguage();
        $filterChain->run();
    }

    protected function setLanguage()
    {
        $lang = \Yii::app()
            ->getRequest()
            ->getParam('lang');

        if (in_array($lang, \Yii::app()->params['Languages']) === false)
            $lang = null;

        if ($lang === null) {
            \Yii::app()->setLanguage($lang);
        }
    }
}