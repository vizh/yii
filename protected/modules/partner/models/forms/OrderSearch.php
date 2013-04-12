<?php
namespace partner\models\forms;

class OrderSearch extends \CFormModel
{
  public $Order;
  public $Company;
  public $INN;
  public $Payer;
  public $Paid;
  public $Deleted;

  public function rules()
  {
    return array(
      array('Order, Company, INN, Payer, Paid, Deleted', 'safe')
    );
  }

  public function attributeLabels()
  {
    return array(
      'Order' => 'Номер счета',
      'Company' => 'Название компании',
      'INN' => 'ИНН компании',
      'Payer' => 'Плательщик',
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
