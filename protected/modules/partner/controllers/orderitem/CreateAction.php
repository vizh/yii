<?php
namespace partner\controllers\orderitem;

class CreateAction extends \partner\components\Action
{
  public $error;

  public function run()
  {
    $this->getController()->setPageTitle('Добавление заказа');
    $this->getController()->initActiveBottomMenu('create');


    $request = \Yii::app()->getRequest();

    $form = new \partner\models\forms\orderitem\Create($this->getEvent());
    $form->attributes = $request->getParam(get_class($form));

    if ($request->getIsPostRequest() && $form->validate())
    {
      $payer = \user\models\User::model()->byRunetId($form->PayerRunetId)->find();
      $owner = \user\models\User::model()->byRunetId($form->OwnerRunetId)->find();

      try{
        $orderItemId = $form->getProduct()->getManager()->createOrderItem($payer, $owner)->Id;
        $searchForm = new \partner\models\forms\OrderItemSearch($this->getEvent());
        $this->getController()->redirect(
          \Yii::app()->createUrl('/partner/orderitem/index', [
            \CHtml::activeName($searchForm, 'OrderItem') => $orderItemId
          ])
        );
      }
      catch (\pay\components\Exception $e)
      {
        $form->addError('OrderItem', $e->getMessage());
      }
    }

    $this->getController()->render('create', ['form' => $form]);
  }
}
