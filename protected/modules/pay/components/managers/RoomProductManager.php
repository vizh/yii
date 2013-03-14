<?php
namespace pay\components\managers;

/**
 * @property string $TechnicalNumber
 * @property string $Hotel
 * @property string $Housing
 * @property string $Category
 * @property string $Number
 * @property string $EuroRenovation
 * @property string $RoomCount
 * @property string $PlaceTotal
 * @property string $PlaceBasic
 * @property string $PlaceMore
 * @property string $DescriptionBasic
 * @property string $DescriptionMore
 * @property string $Price
 *
 * @property string $Visible
 *
 */
class RoomProductManager extends BaseProductManager
{

  /**
   * Возвращает список доступных аттрибутов
   * @return string[]
   */
  public function getProductAttributeNames()
  {
    return array(
      'TechnicalNumber',
      'Hotel',
      'Housing',
      'Category',
      'Number',
      'EuroRenovation',
      'RoomCount',
      'PlaceTotal',
      'PlaceBasic',
      'PlaceMore',
      'DescriptionBasic',
      'DescriptionMore',
      'Price',
      //-------
      'Visible'
    );
  }

  /**
   * Возвращает список необходимых параметров для OrderItem
   * @return string[]
   */
  public function getOrderItemAttributeNames()
  {
    return array('DateIn', 'DateOut');
  }

  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  public function checkProduct($user, $params = array())
  {
    /** @var $participant \event\models\Participant */
    $participant = \event\models\Participant::model()
        ->byUserId($user->UserId)->byEventId($this->product->EventId)->find();
    /** @var $checkRole \event\models\Role */
    $checkRole = \event\models\Role::model()->findByPk(1);
    if (!empty($participant) && $participant->Role->Priority >= $checkRole->Priority)
    {
      return true;
    }

    /** @var $orderItems \pay\models\OrderItem[] */
    $orderItems = \pay\models\OrderItem::model()->byEventId($this->product->EventId)
        ->byPayerId($user->UserId)->byOwnerId($user->UserId)
        ->byDeleted(false)->findAll();

    foreach ($orderItems as $item)
    {
      if ($item->Product->ManagerName == 'EventProductManager')
      {
        return true;
      }
    }
    return false;
  }

  /**
   * Оформляет покупку продукта на пользователя
   * @param \user\models\User $user
   * @param array $params
   *
   * @return bool
   */
  protected function internalBuyProduct($user, $params = array())
  {
    return true;
  }

  /**
   * @param array $params
   * @return array
   */
  protected function getProductIdList($params)
  {
    $productParams = array();
    $orderParams = array();
    foreach ($params as $key => $value)
    {
      if (in_array($key, $this->GetAttributeNames()))
      {
        $productParams[$key] = $value;
      }
      elseif (in_array($key, $this->GetOrderParamNames()))
      {
        $orderParams[$key] = $value;
      }
    }

    $bookSql = '1=1';
    if (!empty($orderParams) && sizeof($orderParams) == 2)
    {
      $sql = "SELECT oi.ProductId FROM Mod_PayOrderItem as oi
                INNER JOIN Mod_PayProduct as p ON oi.ProductId = p.ProductId
                LEFT JOIN Mod_PayOrderItemParam as oip ON oip.OrderItemId = oi.OrderItemId
                WHERE p.EventId = :EventId AND p.Manager = :Manager AND (oi.Paid = :Paid OR oi.Deleted = :Deleted) AND
                (oip.Name = :Name1 AND (oip.Value < :Value1 OR oip.Value < :Value2)
                  OR oip.Name = :Name2 AND (oip.Value > :Value1 OR oip.Value > :Value2))
                GROUP BY oi.OrderItemId
                HAVING count(oip.OrderItemParamId) = :CountParams";

      $command = \Yii::app()->getDb()->createCommand($sql);

      $command->bindValue(':EventId', $this->product->EventId);
      $command->bindValue(':Manager', $this->product->Manager);
      $command->bindValue(':Paid', 1);
      $command->bindValue(':Deleted', 0);
      $command->bindValue(':Name1', 'DateIn');
      $command->bindValue(':Value1', $orderParams['DateIn']);
      $command->bindValue(':Name2', 'DateOut');
      $command->bindValue(':Value2', $orderParams['DateOut']);
      $command->bindValue(':CountParams', sizeof($orderParams));

      $result = $command->queryAll();

      $productIdList = array();
      foreach ($result as $value)
      {
        $productIdList[] = $value['ProductId'];
      }

      if (!empty($productIdList))
      {
        $productIdList = implode(',', $productIdList);
        $bookSql .= " AND p.ProductId NOT IN ($productIdList)";
      }
    }


    $sql = '';
    $params = array();

    if (!empty($productParams))
    {
      $sql = 'AND (0=1';
      $i = 0;
      foreach ($productParams as $key => $value)
      {
        $sql .= " OR pa.Name = :mkey{$i} AND pa.Value = :mvalue{$i}";
        $params[':mkey'.$i] = $key;
        $params[':mvalue'.$i] = $value;
        $i++;
      }
      $sql .= ')';
    }

    $params[':EventId'] = $this->product->EventId;
    $params[':Manager'] = $this->product->Manager;

    $command = \Yii::app()->getDb()->createCommand();
    $command->select('p.ProductId')->from('Mod_PayProduct p');
    $command->leftJoin('Mod_PayProductAttribute pa', 'p.ProductId = pa.ProductId');
    $command->where("p.EventId = :EventId AND p.Manager = :Manager {$sql} AND ({$bookSql})", $params);
    $command->group('p.ProductId');

    if (!empty($productParams))
    {
      $command->having('count(pa.ProductAttributeId) = :CountAttributes', array(':CountAttributes' => sizeof($productParams)));
    }

    $result = $command->queryAll();

    $productIdList = array();
    foreach ($result as $value)
    {
      $productIdList[] = $value['ProductId'];
    }

    return $productIdList;
  }

  /**
   * @param array $params
   * @param array $filter
   * @return array
   */
  public function filter($params, $filter)
  {
    $productIdList = $this->getProductIdList($params);
    if (empty($productIdList))
    {
      return array();
    }

    $result = array();
    if (sizeof($filter) == 1)
    {
      $productIdList = implode(',', $productIdList);
      $productSql = "p.ProductId IN ($productIdList)";
      $filter = $filter[0];

      $sql = "SELECT count(p.ProductId) as Count, pa.Value, min(pp.Price) as MinPrice FROM Mod_PayProduct as p
              LEFT JOIN Mod_PayProductAttribute as pa ON (p.ProductId = pa.ProductId)
              LEFT JOIN Mod_PayProductPrice as pp ON (p.ProductId = pp.ProductId)
              WHERE {$productSql} AND pa.Name = :Filter
              GROUP BY pa.Value";

      $command = \Yii::app()->getDb()->createCommand($sql);

      $command->bindValue(':Filter', $filter);

      $result = $command->queryAll();
    }
    else
    {
      $filterSql = 'Attributes.Name IN (\'' . implode('\',\'', $filter) . '\')';
      $model = \pay\models\Product::model()->with(array('Attributes' => array('on' => $filterSql), 'Prices'));
      $criteria = new \CDbCriteria();
      $criteria->addInCondition('t.ProductId', $productIdList);


      /** @var $products \pay\models\Product[] */
      $products = $model->findAll($criteria);
      foreach ($products as $product)
      {
        $value = array();
        foreach ($filter as $key)
        {
          $value[$key] = $product->GetAttribute($key)->Value;
        }

        $hash = md5(serialize($value));
        if (! isset($result[$hash]))
        {
          $result[$hash] = array('Count' => 0, 'Value' => $value, 'MinPrice' => 10000000);
        }
        $result[$hash]['Count'] += 1;
        $result[$hash]['MinPrice'] = min($result[$hash]['MinPrice'], $product->GetPrice());
      }
      $result = array_values($result);
    }

    return $result;
  }

  /**
   * @param array $params
   * @return \pay\models\Product
   */
  public function getFilterProduct($params)
  {
    $productIdList = $this->getProductIdList($params);
    if (empty($productIdList))
    {
      return null;
    }
    $model = \pay\models\Product::model()->with(array('Attributes', 'Prices'));
    $criteria = new \CDbCriteria();
    $criteria->addInCondition('t.ProductId', $productIdList);
    $criteria->limit = 1;

    return $model->find($criteria);
  }

  /**
   * @param \pay\models\OrderItem $orderItem
   * @return int
   */
  public function getPrice($orderItem)
  {
    $price = parent::getPrice($orderItem);
    $dateIn = $orderItem->getItemAttribute('DateIn');
    $dateOut = $orderItem->getItemAttribute('DateOut');
    $delta = (strtotime($dateOut) - strtotime($dateIn)) / (24 * 60 * 60);
    $delta = max($delta, 1);
    return $price * $delta;
  }

  /**
   * @param \pay\models\OrderItem $orderItem
   * @return string
   */
  public function getTitle($orderItem)
  {
    $title = parent::GetTitle($orderItem);
    $title .= ': пансионат ' . $this->Hotel . ', строение «' . $this->Housing .
      '», категория «' . $this->Category . '», с ' . date('d.m.Y', strtotime($orderItem->getItemAttribute('DateIn'))) .
      ' по ' . date('d.m.Y', strtotime($orderItem->getItemAttribute('DateOut')));
    return $title;
  }

  /**
   * Отменяет покупку продукта на пользовтеля
   * @param \user\models\User $user
   * @return bool
   */
  public function rollbackProduct($user)
  {
    // TODO: Implement RollbackProduct() method.
  }

  /**
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @return bool
   */
  public function redirectProduct($fromUser, $toUser)
  {
    // TODO: Implement RedirectProduct() method.
  }


}