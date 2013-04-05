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

    return $criteria;

    if ( !empty ($filter))
    {
      foreach ($filter as $field => $value)
      {
        if ($value !== '')
        {
          switch ($field)
          {
            case 'OrderItemId':
              $criteria->addCondition('t.OrderItemId = :OrderItemId');
              $criteria->params[':OrderItemId'] = (int) $value;
              break;

            case 'ProductId':
              $criteria->addCondition('t.ProductId = :ProductId');
              $criteria->params[':ProductId'] = (int) $value;
              break;

            case 'Payer':
            case 'Owner':
              $criteria2 = new \CDbCriteria();
              if (strpos($value, '@'))
              {
                $criteria2->condition = 't.Email = :Email OR Emails.Email = :Email';
                $criteria2->params['Email'] = $value;
                $criteria2->with = array('Emails');
              }
              else
              {
                $criteria2 = \user\models\User::GetSearchCriteria($value);
                $criteria2->with = array('Settings');
              }
              $users = \user\models\User::model()->findAll($criteria2);
              $userIdList = array();
              if (!empty($users))
              {
                foreach ($users as $user)
                {
                  $userIdList[] = $user->UserId;
                }
              }
              $criteria->addInCondition($field.'.UserId', $userIdList);
              break;

            case 'Deleted':
            case 'Paid':
              $criteria->addCondition('`t`.`'.$field.'` = :'. $field);
              $criteria->params[':'.$field] = (int) $value;
              break;

          }
        }
        else
        {
          unset ($filter[$field]);
        }
      }
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