<?php
namespace oauth\components;

class Controller extends \application\components\controllers\BaseController
{
  const SelfId = 1;

  public $layout = '/layouts/oauth';

  /** @var \api\models\Account */
  protected $Account = null;

  protected $apiKey = null;
  protected $referer = null;
  protected $refererHash = null;
  protected $url = null;
  protected $social = null;

  protected function initResources()
  {
    parent::initResources();

    \Yii::app()->getClientScript()->registerPackage('runetid.bootstrap');
  }


  public function beforeAction($action)
  {
    \Yii::app()->disableOutputLoggers();
    
    
    $url = \Yii::app()->request->getParam('url');
    if ($url !== null)
    {
      $urlParams = array();
      parse_str(parse_url($url, PHP_URL_QUERY), $urlParams);
      if (isset($urlParams['lang']) 
        && in_array($urlParams['lang'], \Yii::app()->params['Languages']))
      {
        \Yii::app()->setLanguage($urlParams['lang']);
      }
    }
    
    
    $langCookie = isset(\Yii::app()->getRequest()->cookies['lang']) ? \Yii::app()->getRequest()->cookies['lang']->value : null;
    if ($langCookie !== null && in_array($langCookie, \Yii::app()->params['Languages']))
    {
      \Yii::app()->setLanguage($langCookie);
    }

    $request = \Yii::app()->getRequest();
    $this->apiKey = $request->getParam('apikey');
    if ($this->apiKey !== null)
    {
      /** @var $account \api\models\Account */
      $account = \api\models\Account::model()->byKey($this->apiKey)->find();
    }
    else
    {
      $account = \api\models\Account::model()->findByPk(self::SelfId);
    }

    $this->url = $request->getParam('url');
    $this->social = $request->getParam('social');

    if ($account === null)
    {
      throw new \CHttpException(400, 'Не найден аккаунт внешнего агента');
    }

    if ($account->Id !== self::SelfId && (empty($this->url) || !$account->checkUrl($this->url)))
    {
      throw new \CHttpException(400, 'Не корректно задан путь возврата' . $this->url);
    }
    else
    {
      $this->Account = $account;
    }

    return true;
  }

  public function createUrl($route, $params = array(), $ampersand = '&')
  {
    if (!empty($this->apiKey))
    {
      $params['apikey'] = $this->apiKey;
    }
    $params = array_merge(array(
      'url' => $this->url,
      'social' => $this->social,
    ), $params);
    return parent::createUrl($route, $params, $ampersand);
  }
}
