<?php
namespace widget\components;

use api\models\Account;
use application\components\controllers\MainController;

class Controller extends MainController
{
    protected $useBootstrap3 = false;

    public $layout = '/layouts/public';

    public $apiKey;

    public $url;

    /**
     * Initializes the controller.
     * This method is called by the application before the controller starts to execute.
     * You may override this method to perform the needed initialization for the controller.
     */
    public function init()
    {
        $request = \Yii::app()->getRequest();
        $this->apiKey = $request->getParam('apikey');

        if ($this->apiKey !== null) {
            $this->apiAccount = Account::model()->byKey($this->apiKey)->find();
        }
        try {
            if ($this->apiAccount === null) {
                throw new \CHttpException(400, "Некорректный ApiKey: {$this->apiKey}");
            }

            $this->url = $request->getParam('url');

            if (empty($this->url) || !$this->apiAccount->checkUrl($this->url)) {
                throw new \CHttpException(400, "Адрес {$this->url} не согласован для расположения виджета");
            }
        } catch (\CHttpException $e) {
            // Для проблем с отображением виджета выведем человекопонятное сообщение
            if ($request->getPathInfo() === 'widget/registration/index') {
                echo "<script>alert('Ошибка! {$e->getMessage()}')</script>";
                exit;
            }
            // Для всех остальных, - бросаем исключение далее
            throw $e;
        }
        parent::init();
    }

    protected function initResources()
    {
        if ($this->useBootstrap3) {
            $this->layout = '/layouts/public-b3';
            \Yii::app()->getClientScript()->registerPackage('runetid.widget.b3');
        } else {
            \Yii::app()->getClientScript()->registerPackage('runetid.widget');
        }
        if ($this->getApiAccount() !== null) {
            \Yii::app()->getClientScript()->registerMetaTag($this->getApiAccount()->Key, 'ApiKey');
        }
        parent::initResources();
    }

    private $apiAccount;

    /**
     * @return null|Account
     */
    public function getApiAccount()
    {
        return $this->apiAccount;
    }

    public function beforeAction($action)
    {
        header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');
        return true;
    }

    public function createUrl($route, $params = [], $ampersand = '&')
    {
        $request = \Yii::app()->getRequest();
        $params['apikey'] = $request->getParam('apikey');
        $params['url'] = $request->getParam('url');
        foreach ($this->getWidgetParamValues() as $name => $value) {
            if ($value !== null) {
                $params[$this->getWidgetRequestParamName($name)] = $value;
            }
        }
        return parent::createUrl($route, $params, $ampersand); // TODO: Change the autogenerated stub
    }

    /**
     * @return \event\models\Event
     */
    public function getEvent()
    {
        return $this->getApiAccount()->Event;
    }

    /**
     * @return array
     */
    protected function getWidgetParamNames()
    {
        return [];
    }

    /**
     * @param $name
     * @return mixed
     * @throws \Exception
     */
    public function getWidgetParamValue($name)
    {
        if (!in_array($name, $this->getWidgetParamNames())) {
            throw new \Exception('Виджет не имеет параметра '.$name);
        }

        return $this->getWidgetParamValues()[$name];
    }

    private $widgetParamValues;

    /**
     * @return array|null
     */
    public function getWidgetParamValues()
    {
        if ($this->widgetParamValues == null) {
            $this->widgetParamValues = [];
            $request = \Yii::app()->getRequest();
            foreach ($this->getWidgetParamNames() as $name) {
                $this->widgetParamValues[$name] = $request->getParam($this->getWidgetRequestParamName($name));
            }
        }
        return $this->widgetParamValues;
    }

    /**
     * @param $name
     * @return string
     */
    protected function getWidgetRequestParamName($name)
    {
        return 'param-'.$name;
    }

    /**
     * @return \user\models\User|null
     */
    public function getUser()
    {
        if (\Yii::app()->user->getCurrentUser() !== null) {
            return \Yii::app()->user->getCurrentUser();
        } elseif (\Yii::app()->tempUser->getCurrentUser() !== null) {
            return \Yii::app()->tempUser->getCurrentUser();
        }
        return null;
    }
}