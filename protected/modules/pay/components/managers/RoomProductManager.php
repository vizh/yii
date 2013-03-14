<?php
namespace pay\components\managers;

class RoomProductManager extends BaseProductManager
{

  /**
   * Возвращает список доступных аттрибутов
   * @return string[]
   */
  public function GetAttributeNames()
  {

    return array('Visible', 'Hotel', 'TechnicalNumber', 'Housing', 'Category', 'Number', 'EuroRenovation', 'RoomCount',
      'SleepCount', 'BedCount', 'RoomDescription', 'AdditionalDescription', 'Price');
  }

  /**
   * Возвращает список необходимых параметров для OrderItem
   * @return string[]
   */
  public function GetOrderParamNames()
  {
    return array('DateIn', 'DateOut');
  }

  /**
   * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
   * @param \user\models\User $user
   * @param array $params
   * @return bool
   */
  public function CheckProduct($user, $params = array())
  {
    $eventUser = \event\models\Participant::GetByUserEventId($user->UserId, $this->product->EventId);
    $checkRole = \event\models\Role::GetById(1);
    if (!empty($eventUser) && $eventUser->Role->Priority >= $checkRole->Priority)
    {
      return true;
    }

    //$orderItems = OrderItem::GetByEventId($user->UserId, $this->product->EventId);
    $orderItems = \pay\models\OrderItem::GetAllByEventId($this->product->EventId, $user->UserId, $user->UserId);
    foreach ($orderItems as $item)
    {
      if ($item->PayerId == $user->UserId && $item->OwnerId == $user->UserId && $item->Product->Manager == 'EventProductManager')
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
   * @return bool
   */
  public function BuyProduct($user, $params = array())
  {
    // TODO: Implement BuyProduct() method.
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
  public function Filter($params, $filter)
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
  public function GetFilterProduct($params)
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
  public function GetPrice($orderItem)
  {
    $price = parent::GetPrice($orderItem);
    $dateIn = $orderItem->GetParam('DateIn')->Value;
    $dateOut = $orderItem->GetParam('DateOut')->Value;
    $delta = (strtotime($dateOut) - strtotime($dateIn)) / (24 * 60 * 60);
    $delta = max($delta, 1);
    return $price * $delta;
  }

  /**
   * @param \pay\models\OrderItem $orderItem
   * @return string
   */
  public function GetTitle($orderItem)
  {
    $title = parent::GetTitle($orderItem);
    $title .= ': пансионат ' . $this->product->GetAttribute('Hotel')->Value . ', строение «' . $this->product->GetAttribute('Housing')->Value .
      '», категория «' . $this->product->GetAttribute('Category')->Value . '», с ' . date('d.m.Y', strtotime($orderItem->GetParam('DateIn')->Value)) .
      ' по ' . date('d.m.Y', strtotime($orderItem->GetParam('DateOut')->Value));
    return $title;
  }

  /**
   * Отменяет покупку продукта на пользовтеля
   * @param \user\models\User $user
   * @return bool
   */
  public function RollbackProduct($user)
  {
    // TODO: Implement RollbackProduct() method.
  }

  /**
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @return bool
   */
  public function RedirectProduct($fromUser, $toUser)
  {
    // TODO: Implement RedirectProduct() method.
  }
}