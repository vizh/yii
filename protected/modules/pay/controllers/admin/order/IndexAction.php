<?php
namespace pay\controllers\admin\order;

class IndexAction extends \CAction
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск счетов');

    $form = new \partner\models\forms\OrderSearch();
    $form->attributes = \Yii::app()->getRequest()->getParam(get_class($form));
    $criteria = $this->getCriteria($form);
    $count = \pay\models\Order::model()->count($criteria);


    $paginator = new \application\components\utility\Paginator($count);
    $paginator->perPage = \Yii::app()->params['PartnerOrderPerPage'];
    $criteria->mergeWith($paginator->getCriteria());
    $criteria->order = '"t"."CreationTime" DESC';

    $orders = \pay\models\Order::model()->findAll($criteria);

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

    if ((int)$form->Order !== 0)
    {
      $criteria->addCondition('"t"."Id" = :OrderId');
      $criteria->params['OrderId'] =(int)$form->Order;
    }

    if ($form->Paid !== '' && $form->Paid !== null)
    {
      $criteria->addCondition(($form->Paid == 0 ? 'NOT ' : '') . '"t"."Paid"');
    }
    if ($form->Deleted !== '' && $form->Deleted !== null)
    {
      $criteria->addCondition(($form->Deleted == 0 ? 'NOT ' : '') . '"t"."Deleted"');
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
      $criteria->params['RunetId'] = $form->Payer;
    }
    else
    {
      $criteria->with[] = 'Payer';
    }
    $criteria->with['Payer.LinkPhones.Phone'] = array('together' => false);

    return $criteria;
  }
}