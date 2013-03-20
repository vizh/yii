<?php
namespace event\widgets;

class Registration extends \event\components\Widget
{
  public function process()
  {
    $request = \Yii::app()->getRequest();
    $product = $request->getParam('product', array());
    if ($request->getIsPostRequest() && sizeof($product) !== 0)
    {
      $this->getController()->redirect(\Yii::app()->createUrl('/pay/cabinet/register', array('eventIdName' => $this->event->IdName)));
    }
  }


  public function run()
  {
    /** @var $account \pay\models\Account */
    $account = \pay\models\Account::model()->byEventId($this->event->Id)->find();
    if ($account === null)
    {
      return;
    }

    if ($account->ReturnUrl === null)
    {
      \Yii::app()->getClientScript()->registerPackage('runetid.event-calculate-price');
      $products = \pay\models\Product::model()->byEventId($this->event->Id)
          ->byPublic(true)->findAll();
      $this->render('registration', array('products' => $products));
    }
    else
    {
      $this->render('registration-external', array('account' => $account));
    }
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Регистрация на мероприятии');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Content;
  }
}