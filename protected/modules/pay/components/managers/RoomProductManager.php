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
        ->byUserId($user->Id)->byEventId($this->product->EventId)->find();
    /** @var $checkRole \event\models\Role */
    $checkRole = \event\models\Role::model()->findByPk(1);
    if (!empty($participant) && $participant->Role->Priority >= $checkRole->Priority)
    {
      return true;
    }

    /** @var $orderItems \pay\models\OrderItem[] */
    $orderItems = \pay\models\OrderItem::model()->byEventId($this->product->EventId)
        ->byPayerId($user->Id)->byOwnerId($user->Id)
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
   * @param \pay\models\OrderItem $orderItem
   * @param array $params
   *
   * @return bool
   */
  protected function internalBuyProduct($user, $orderItem = null, $params = array())
  {
    return true;
  }

  /**
   * @param array $params
   * @return array
   */
  protected function getProductIdList($params)
  {
    $productAttributes = array();
    $orderAttributes = array();
    foreach ($params as $key => $value)
    {
      if (in_array($key, $this->getProductAttributeNames()))
      {
        $productAttributes[$key] = $value;
      }
      elseif (in_array($key, $this->getOrderItemAttributeNames()))
      {
        $orderAttributes[$key] = $value;
      }
    }

    $bookSql = '1=1';
    if (!empty($orderAttributes) && sizeof($orderAttributes) == 2)
    {
      $sql = 'SELECT "oi"."ProductId" FROM "PayOrderItem" as oi
                INNER JOIN "PayProduct" as "p" ON "oi"."ProductId" = "p"."Id"
                LEFT JOIN "PayOrderItemAttribute" as "oia" ON "oia"."OrderItemId" = "oi"."Id"
                WHERE "p"."EventId" = :EventId AND "p"."ManagerName" = :ManagerName AND ("oi"."Paid" OR NOT "oi"."Deleted") AND
                ("oia"."Name" = :Name1 AND ("oia"."Value" < :Value1 OR "oia"."Value" < :Value2)
                  OR "oia"."Name" = :Name2 AND ("oia"."Value" > :Value1 OR "oia"."Value" > :Value2))
                GROUP BY "oi"."Id"
                HAVING count("oia"."Id") = :CountParams';

      $command = \Yii::app()->getDb()->createCommand($sql);
      $command->bindValue('EventId', $this->product->EventId);
      $command->bindValue('ManagerName', $this->product->ManagerName);
      $command->bindValue('Name1', 'DateIn');
      $command->bindValue('Value1', $orderAttributes['DateIn']);
      $command->bindValue('Name2', 'DateOut');
      $command->bindValue('Value2', $orderAttributes['DateOut']);
      $command->bindValue('CountParams', sizeof($orderAttributes));
      $result = $command->queryAll();

      $productIdList = [];
      foreach ($result as $value)
      {
        $productIdList[] = $value['ProductId'];
      }

      $command = \Yii::app()->getDb()->createCommand('
      SELECT rpb."ProductId" FROM "PayRoomPartnerBooking"  rpb
        INNER JOIN "PayProduct" p ON rpb."ProductId" = p."Id"
        WHERE p."EventId" = :EventId AND (NOT rpb."Deleted" OR rpb."Paid") AND
        (rpb."DateIn" < :DateIn OR rpb."DateIn" < :DateOut OR
          rpb."DateOut" > :DateIn OR rpb."DateOut" > :DateOut)
      ');
      $command->bindValue('EventId', $this->product->EventId);
      $command->bindValue('DateIn', $orderAttributes['DateIn']);
      $command->bindValue('DateOut', $orderAttributes['DateOut']);
      $result = $command->queryAll();

      foreach ($result as $value)
      {
        $productIdList[] = $value['ProductId'];
      }

      if (!empty($productIdList))
      {
        $productIdList = implode(',', $productIdList);
        $bookSql .= sprintf(' AND "p"."Id" NOT IN (%s)', $productIdList);
      }
    }


    $sql = '';
    $params = array();

    if (!empty($productAttributes))
    {
      $sql = 'AND (0=1';
      $i = 0;
      foreach ($productAttributes as $key => $value)
      {
        $sql .= sprintf(' OR "pa"."Name" = :mkey%1$d AND "pa"."Value" = :mvalue%1$d', $i);
        $params[':mkey'.$i] = $key;
        $params[':mvalue'.$i] = $value;
        $i++;
      }
      $sql .= ')';
    }

    $params[':EventId'] = $this->product->EventId;
    $params[':ManagerName'] = $this->product->ManagerName;

    $command = \Yii::app()->getDb()->createCommand();
    $command->select('p.Id')->from('PayProduct p');
    $command->leftJoin('PayProductAttribute pa', '"p"."Id" = "pa"."ProductId"');
    $command->where(sprintf('"p"."EventId" = :EventId AND "p"."ManagerName" = :ManagerName %s AND (%s)', $sql, $bookSql), $params);
    $command->group('p.Id');

    if (!empty($productAttributes))
    {
      $command->having('count("pa"."Id") = :CountAttributes', array(':CountAttributes' => sizeof($productAttributes)));
    }

    $result = $command->queryAll();

    $productIdList = array();
    foreach ($result as $value)
    {
      $productIdList[] = $value['Id'];
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
      $productSql = sprintf('"p"."Id" IN (%s)', $productIdList);
      $filter = $filter[0];

      $sql = 'SELECT count("p"."Id") as "Count", "pa"."Value", min("pp"."Price") as "MinPrice" FROM "PayProduct" as "p"
              LEFT JOIN "PayProductAttribute" as "pa" ON ("p"."Id" = "pa"."ProductId")
              LEFT JOIN "PayProductPrice" as "pp" ON ("p"."Id" = "pp"."ProductId")
              WHERE '.$productSql.' AND "pa"."Name" = :Filter
              GROUP BY "pa"."Value"';

      $command = \Yii::app()->getDb()->createCommand($sql);

      $command->bindValue(':Filter', $filter);

      $result = $command->queryAll();
    }
    else
    {
      $filterSql = '"Attributes"."Name" IN (\'' . implode('\',\'', $filter) . '\')';
      $model = \pay\models\Product::model()->with(array('Attributes' => array('on' => $filterSql), 'Prices'));
      $criteria = new \CDbCriteria();
      $criteria->addInCondition('"t"."Id"', $productIdList);


      /** @var $products \pay\models\Product[] */
      $products = $model->findAll($criteria);
      foreach ($products as $product)
      {
        $value = array();
        foreach ($filter as $key)
        {
          $value[$key] = $product->getManager()->$key;
        }

        $hash = md5(serialize($value));
        if (! isset($result[$hash]))
        {
          $result[$hash] = array('Count' => 0, 'Value' => $value, 'MinPrice' => 10000000);
        }
        $result[$hash]['Count'] += 1;
        $result[$hash]['MinPrice'] = min($result[$hash]['MinPrice'], $product->getPrice());
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
    $criteria->addInCondition('"t"."Id"', $productIdList);
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

  }

  /**
   *
   * @param \user\models\User $fromUser
   * @param \user\models\User $toUser
   * @param array $params
   *
   * @return bool
   */
  public function internalChangeOwner($fromUser, $toUser, $params = array())
  {
    return true;
  }
}