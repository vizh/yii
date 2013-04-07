<?php
namespace partner\models\forms;


class OrderItemSearch extends \CFormModel
{
  public $OrderItem;
  public $Order;
  public $Product;
  public $Payer;
  public $Owner;
  public $Paid;
  public $Deleted;


  public function rules()
  {
    return array(
      array('OrderItem, Order, Product, Payer, Owner, Paid, Deleted', 'safe')
    );
  }

  /**
   * @return \CDbCriteria
   */
  public function getCriteria()
  {
    $criteria = new \CDbCriteria();

    if ((int)$this->OrderItem !== 0)
    {
      $criteria->addCondition('"t"."Id" = :OrderItemId');
      $criteria->params['OrderItemId'] =(int)$this->OrderItem;
    }

    if ((int)$this->Order !== 0)
    {
      $criteria->addCondition('"OrderLinks"."OrderId" = :OrderId');
      $criteria->params['OrderId'] =(int)$this->Order;
      $criteria->with['OrderLinks'] = array('together' => true);
    }

    if ((int)$this->Payer !== 0)
    {
      $criteria->with['Payer'] = array('together' => true);
      $criteria->addCondition('"Payer"."RunetId" = :PayerRunetId');
      $criteria->params['PayerRunetId'] = (int)$this->Payer;
    }
    else
    {
      $criteria->with[] = 'Payer';
    }

    if ((int)$this->Owner !== 0)
    {
      $criteria->with['Owner'] = array('together' => true);
      $criteria->with['ChangedOwner'] = array('together' => true);
      $criteria->addCondition('"Owner"."RunetId" = :OwnerRunetId OR "ChangedOwner"."RunetId" = :OwnerRunetId');
      $criteria->params['OwnerRunetId'] = (int)$this->Owner;
    }
    else
    {
      $criteria->with[] = 'Owner';
      $criteria->with[] = 'ChangedOwner';
    }

    if ($this->Paid !== '' && $this->Paid !== null)
    {
      $criteria->addCondition(($this->Paid == 0 ? 'NOT ' : '') . '"t"."Paid"');
    }
    if ($this->Deleted !== '' && $this->Deleted !== null)
    {
      $criteria->addCondition(($this->Deleted == 0 ? 'NOT ' : '') . '"t"."Deleted"');
    }

    return $criteria;
  }

  public function attributeLabels()
  {
    return array(
      'OrderItem' => 'Номер элемента заказа',
      'Order' => 'Номер счета',
      'Product' => 'Товар',
      'Payer' => 'Плательщик',
      'Owner' => 'Получатель',
      'Paid' => 'Оплачен',
      'Deleted' => 'Удален',
    );
  }

  public function getListValues()
  {
    return array(
      '' => '',
      1 => 'Да',
      0 => 'Нет',
    );
  }
}