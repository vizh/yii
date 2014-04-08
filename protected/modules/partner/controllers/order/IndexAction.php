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
        ->byEventId($event->Id)->count($criteria);


    $paginator = new \application\components\utility\Paginator($count);
    $paginator->perPage = \Yii::app()->params['PartnerOrderPerPage'];
    $criteria->mergeWith($paginator->getCriteria());
    $criteria->order = '"t"."CreationTime" DESC';

    $orders = \pay\models\Order::model()
        ->byEventId($event->Id)->findAll($criteria);

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
      'ItemLinks.OrderItem' => array('together' => false)
    );

    if (!empty($form->Order))
    {
      if ((int) $form->Order != 0)
      {
        $criteria->addCondition('"t"."Id" = :OrderId');
        $criteria->params['OrderId'] = $form->Order;
      }
      $criteria->addCondition('"t"."Number" ilike :OrderNumber', 'OR');
      $criteria->params['OrderNumber'] = '%'.$form->Order.'%';
    }

    if ($form->Paid !== '' && $form->Paid !== null)
    {
      $criteria->addCondition(($form->Paid == 0 ? 'NOT ' : '') . '"t"."Paid"');
    }

    if ($form->Deleted == '1')
    {
      $criteria->addCondition('("t"."Deleted" AND NOT "t"."Paid")');
    }
    else
    {
      $criteria->addCondition('NOT "t"."Deleted" OR "t"."Paid"');
    }

    if ($form->INN != '' || $form->Company != '')
    {
      $criteria->with['OrderJuridical'] = array('together' => true);
      if ($form->Company != '')
      {
        $criteria->addCondition('"OrderJuridical"."Name" = :Company');
        $criteria->params['Company'] = $form->Company;
      }
      if ($form->INN != '')
      {
        $criteria->addCondition('"OrderJuridical"."INN" = :INN');
        $criteria->params['INN'] = $form->INN;
      }
    }
    else
    {
      $criteria->with[] = 'OrderJuridical';
    }

    if ((int)$form->Payer !== 0)
    {
      $criteria->with['Payer'] = array('together' => true);
      $criteria->addCondition('"Payer"."RunetId" = :RunetId');
      $criteria->params['RunetId'] = (int)$form->Payer;
    }
    else
    {
      $criteria->with[] = 'Payer';
    }
    $criteria->with['Payer.LinkPhones.Phone'] = array('together' => false);

    return $criteria;
  }
}