<?php
namespace oauth\components;

use api\models\Account;

class Controller extends \application\components\controllers\BaseController
{
    const SelfId = 1;

    public $layout = '/layouts/oauth';
    public $bodyId;

    /** @var \api\models\Account */
    protected $Account;

    protected $apiKey;
    protected $referer;
    protected $refererHash;
    protected $url;
    protected $social;
    protected $fast;

    protected function initResources()
    {
        \Yii::app()->getClientScript()->registerPackage('bootstrap3');
        parent::initResources();
    }

    /**
     * @param \CAction $action
     * @return bool
     * @throws \CHttpException
     */

    public function beforeAction($action)
    {
        \Yii::app()->disableOutputLoggers();

        $url = \Yii::app()->request->getParam('url');
        if ($url !== null) {
            $urlParams = [];
            parse_str(parse_url($url, PHP_URL_QUERY), $urlParams);
            if (isset($urlParams['lang'])
                && in_array($urlParams['lang'], \Yii::app()->params['Languages'])
            ) {
                \Yii::app()->setLanguage($urlParams['lang']);
            }
        }

        $langCookie = isset(\Yii::app()->getRequest()->cookies['lang']) ? \Yii::app()->getRequest()->cookies['lang']->value : null;
        if ($langCookie !== null && in_array($langCookie, \Yii::app()->params['Languages'])) {
            \Yii::app()->setLanguage($langCookie);
        }

        $request = \Yii::app()->getRequest();
        $this->apiKey = $request->getParam('apikey');
        if ($this->apiKey !== null) {
            $account = Account::model()->byKey($this->apiKey)->find();
        } else {
            $account = Account::model()->findByPk(Account::SELF_ID);
        }

        $this->url = $request->getParam('url');
        $this->social = $request->getParam('social');
        $this->fast = $request->getParam('fast');

        if ($account === null) {
            throw new \CHttpException(400, 'Не найден аккаунт внешнего агента');
        }

        if ($account->checkUrl($this->url)) {
            $this->Account = $account;
        } else {
            throw new \CHttpException(400, "Не корректно задан путь возврата {$this->url}");
        }

        return true;
    }

    /**
     * @param string $route
     * @param array $params
     * @param string $ampersand
     * @return string
     */

    public function createUrl($route, $params = [], $ampersand = '&')
    {
        if (!empty($this->apiKey)) {
            $params['apikey'] = $this->apiKey;
        }
        if (!empty($this->url)) {
            $params['url'] = $this->url;
        }

        $params = array_merge([
            'social' => $this->social
        ], $params);
        if ($this->fast !== null) {
            $params['fast'] = $this->fast;
        }
        return parent::createUrl($route, $params, $ampersand);
    }
}