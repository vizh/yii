<?php
namespace widget\components;

class Controller extends \application\components\controllers\MainController
{
  private $apiAccount = null;

  public $layout = '/layouts/public';
  public $apiKey;
  public $url;

  protected function initResources()
  {
    \Yii::app()->getClientScript()->registerPackage('runetid.widget');
    if ($this->getApiAccount() !== null)
    {
      \Yii::app()->getClientScript()->registerMetaTag($this->getApiAccount()->Key, 'ApiKey');
    }
    parent::initResources();
  }

  public function getApiAccount()
  {
    return $this->apiAccount;
  }


  public function beforeAction($action)
  {
    //\Yii::app()->disableOutputLoggers();
      header('P3P: CP="IDC DSP COR ADM DEVi TAIi PSA PSD IVAi IVDi CONi HIS OUR IND CNT"');

    $request = \Yii::app()->getRequest();
    $this->apiKey = $request->getParam('apikey');

    if ($this->apiKey !== null)
    {
      $this->apiAccount = \api\models\Account::model()->byKey($this->apiKey)->find();
    }
    $this->url = $request->getParam('url');
    if ($this->apiAccount === null)
    {
      throw new \CHttpException(400, 'Не найден аккаунт внешнего агента');
    }

    if (empty($this->url) || !$this->apiAccount->checkUrl($this->url))
    {
      throw new \CHttpException(400, 'Не корректно задан путь возврата' . $this->url);
    }
    return true;
  }


  public function createUrl($route, $params = array(), $ampersand = '&')
  {
    $request = \Yii::app()->getRequest();
    $params['apikey'] = $request->getParam('apikey');
    $params['url'] = $request->getParam('url');
    foreach ($this->getWidgetParamValues() as $name => $value)
    {
      if ($value !== null)
      {
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
  protected  function getWidgetParamNames()
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
    if (!in_array($name, $this->getWidgetParamNames()))
      throw new \Exception('Виджет не имеет параметра ' . $name);

    return $this->getWidgetParamValues()[$name];
  }

  private $widgetParamValues = null;

  /**
   * @return array|null
   */
  public function getWidgetParamValues()
  {
    if ($this->widgetParamValues == null)
    {
      $this->widgetParamValues = [];
      $request = \Yii::app()->getRequest();
      foreach ($this->getWidgetParamNames() as $name)
      {
        $this->widgetParamValues[$name] = $request->getParam($this->getWidgetRequestParamName($name));
      }
    }
    return $this->widgetParamValues;
  }

  /**
   * @param $name
   * @return string
   */
  protected  function getWidgetRequestParamName($name)
  {
    return 'param-'.$name;
  }
} 