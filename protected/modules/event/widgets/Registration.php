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
    \Yii::app()->getClientScript()->registerPackage('runetid.event-calculate-price');

    $products = \pay\models\Product::model()->byEventId($this->event->Id)
        ->byPublic(true)->findAll();

    $this->render('registration', array('products' => $products));
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