<?php
namespace partner\controllers\order;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск счетов');
    $this->getController()->initActiveBottomMenu('index');

    $event = \Yii::app()->partner->getEvent();

    $form = new \partner\models\forms\OrderSearch();
    $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
    $criteria = $this->getCriteria($form);
    $count = \pay\models\Order::model()
        ->byEventId($event->Id)->byJuridical(true)->count($criteria);


    $paginator = new \application\components\utility\Paginator($count);
    $paginator->perPage = \Yii::app()->params['PartnerOrderPerPage'];
    $criteria->mergeWith($paginator->getCriteria());
    $criteria->order = '"t"."CreationTime" DESC';

    $orders = \pay\models\Order::model()
        ->byEventId($event->Id)->byJuridical(true)
        ->findAll($criteria);

    $this->getController()->render('index',
      array(
        'form' => $form,
        'orders' => $orders,
        'paginator' => $paginator
      )
    );
  }

  /**
   * @param \partner\models\forms\OrderSearch $form
   *
   * @return \CDbCriteria
   */
  protected function getCriteria($form)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'OrderJuridical',
      'Payer',
      'Payer.LinkPhones.Phone' => array('together' => false),
      'ItemLinks.OrderItem' => array('together' => false)
    );

    if ((int)$form->Order !== 0)
    {
      $criteria->addCondition('"t"."Id" = :OrderId');
      $criteria->params['OrderId'] =(int)$form->Order;
    }

    if ($form->Paid !== '')
    {
      $criteria->addCondition(($form->Paid = 0 ? 'NOT ' : '') . '"t"."Paid"');
    }
    if ($form->Deleted !== '')
    {
      $criteria->addCondition(($form->Deleted = 0 ? 'NOT ' : '') . '"t"."Deleted"');
    }

    return $criteria;
  }
}