<?php
namespace oauth\components;

class Controller extends \application\components\controllers\BaseController
{
  public $layout = '/layouts/oauth';

  /** @var \api\models\Account */
  protected $Account = null;

  protected $apiKey = null;
  protected $referer = null;
  protected $refererHash = null;
  protected $url = null;
  protected $social = null;

  public function beforeAction($action)
  {
    $request = \Yii::app()->getRequest();
    $this->apiKey = $request->getParam('ApiKey');
    /** @var $account \api\models\Account */
    $account = \api\models\Account::model()->byKey($this->apiKey)->find();
    $this->url = $request->getParam('url');
    $this->social = $request->getParam('social');
    if (empty($account) || empty($this->url))
    {
      throw new \CHttpException(400);
    }

    $this->referer = $request->getParam('referer', null);
    $this->refererHash = $request->getParam('hash', null);
    if (empty($this->referer))
    {
      $this->referer = parse_url($_SERVER['HTTP_REFERER'], PHP_URL_HOST);
      $this->refererHash = $account->getRefererHash($this->referer);
    }
    if (!$account->checkReferer($this->referer, $this->refererHash))
    {
      throw new \CHttpException(400);
    }
    else
    {
      $this->Account = $account;
    }
    return true;
  }

  public function createUrl($route, $params = array(), $ampersand = '&')
  {
    $request = \Yii::app()->getRequest();
    $params = array_merge(array(
      'ApiKey' => $this->apiKey,
      'r_state' => $request->getParam('r_state'),
      'url' => $this->url,
      'social' => $this->social,
      'referer' => $this->referer,
      'hash' => $this->refererHash
    ), $params);
    return parent::createUrl($route, $params, $ampersand);
  }
}
