<?php
namespace pay\components\managers;

use event\models\Participant;
use event\models\Role;
use pay\components\MessageException;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;

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
 * @property string $AdditionalPrice
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
        return array_merge([
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
            'AdditionalPrice',
            'Visible'
        ], parent::getProductAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredProductAttributeNames()
    {
        return [
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
            'AdditionalPrice',
            'Visible'
        ];
    }

    /**
     * Возвращает список необходимых параметров для OrderItem
     * @return string[]
     */
    public function getOrderItemAttributeNames()
    {
        return array_merge(['DateIn', 'DateOut', 'Reserved'], parent::getOrderItemAttributeNames());
    }

    /**
     * @inheritdoc
     */
    public function getRequiredOrderItemAttributeNames()
    {
        return ['DateIn', 'DateOut'];
    }

    /**
     * Возвращает true - если продукт может быть приобретен пользователем, и false - иначе
     * @param User $user
     * @param array $params
     * @return bool
     */
    public function checkProduct($user, $params = [])
    {
        /** @var Participant $participant */
        $participant = Participant::model()
            ->byUserId($user->Id)
            ->byEventId($this->product->EventId)
            ->find();

        /** @var $checkRole Role */
        $checkRole = Role::model()->findByPk(1);
        if ($participant && $participant->Role->Priority >= $checkRole->Priority) {
            return true;
        }

        /** @var OrderItem[] $orderItems */
        $orderItems = OrderItem::model()
            ->byEventId($this->product->EventId)
            ->byPayerId($user->Id)
            ->byOwnerId($user->Id)
            ->byDeleted(false)
            ->findAll();

        foreach ($orderItems as $item) {
            if ($item->Product->ManagerName === BaseProductManager::EVENT) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param array $params
     * @param array $filter
     * @return array
     */
    public function filter($params, $filter)
    {
        $productIdList = $this->getProductIdList($params);
        if (empty($productIdList)) {
            return [];
        }

        $result = [];
        if (sizeof($filter) == 1) {
            $productIdList = implode(',', $productIdList);
            $productSql = sprintf('"p"."Id" IN (%s)', $productIdList);
            $filter = $filter[0];

            $sql = 'SELECT count("p"."Id") AS "Count", "pa"."Value", min("pp"."Price") AS "MinPrice" FROM "PayProduct" AS "p"
              LEFT JOIN "PayProductAttribute" AS "pa" ON ("p"."Id" = "pa"."ProductId")
              LEFT JOIN "PayProductPrice" AS "pp" ON ("p"."Id" = "pp"."ProductId")
              WHERE '.$productSql.' AND "pa"."Name" = :Filter AND NOT "p"."Deleted"
              GROUP BY "pa"."Value"';

            $command = \Yii::app()->getDb()->createCommand($sql);

            $command->bindValue(':Filter', $filter);

            $result = $command->queryAll();
        } else {
            $filterSql = '"Attributes"."Name" IN (\''.implode('\',\'', $filter).'\')';
            $model = Product::model()->with([
                'Attributes' => [
                    'on' => $filterSql
                ],
                'Prices'
            ]);

            $criteria = new \CDbCriteria();
            $criteria->addInCondition('"t"."Id"', $productIdList);

            /** @var $products Product[] */
            $products = $model->findAll($criteria);

            foreach ($products as $product) {
                $value = [];
                foreach ($filter as $key) {
                    $value[$key] = $product->getManager()->$key;
                }

                $hash = md5(serialize($value));
                if (!isset($result[$hash])) {
                    $result[$hash] = ['Count' => 0, 'Value' => $value, 'MinPrice' => 10000000];
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
     * @return Product
     */
    public function getFilterProduct($params)
    {
        $productIdList = $this->getProductIdList($params);
        if (empty($productIdList)) {
            return null;
        }

        $model = Product::model()->with(['Attributes', 'Prices']);

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."Id"', $productIdList);
        $criteria->limit = 1;

        return $model->find($criteria);
    }

    /**
     * @param OrderItem $orderItem
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
     * @param OrderItem $orderItem
     * @return string
     */
    public function getTitle($orderItem)
    {
        $title = parent::GetTitle($orderItem);
        $title .= ': пансионат '.$this->Hotel.', строение «'.$this->Housing.
            '», категория «'.$this->Category.'», с '.date('d.m.Y', strtotime($orderItem->getItemAttribute('DateIn'))).
            ' по '.date('d.m.Y', strtotime($orderItem->getItemAttribute('DateOut')));

        return $title;
    }

    /**
     * Оформляет покупку продукта на пользователя
     * @param User $user
     * @param OrderItem $orderItem
     * @param array $params
     *
     * @return bool
     */
    protected function internalBuy($user, $orderItem = null, $params = [])
    {
        return true;
    }

    /**
     * @param array $params
     * @return array
     */
    protected function getProductIdList($params)
    {
        $productAttributes = [];
        $orderAttributes = [];

        foreach ($params as $key => $value) {
            if (in_array($key, $this->getProductAttributeNames())) {
                $productAttributes[$key] = $value;
            } elseif (in_array($key, $this->getOrderItemAttributeNames())) {
                $orderAttributes[$key] = $value;
            }
        }

        $bookSql = '1=1';
        if (!empty($orderAttributes) && sizeof($orderAttributes) == 2) {
            $sql = 'SELECT "oi"."ProductId" FROM "PayOrderItem" AS oi
                INNER JOIN "PayProduct" AS "p" ON "oi"."ProductId" = "p"."Id"
                LEFT JOIN "PayOrderItemAttribute" AS "oia" ON "oia"."OrderItemId" = "oi"."Id"
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
            foreach ($result as $value) {
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

            foreach ($result as $value) {
                $productIdList[] = $value['ProductId'];
            }

            if (!empty($productIdList)) {
                $productIdList = implode(',', $productIdList);
                $bookSql .= sprintf(' AND "p"."Id" NOT IN (%s)', $productIdList);
            }
        }

        $sql = '';
        $params = [];

        if (!empty($productAttributes)) {
            $sql = 'AND (0=1';
            $i = 0;
            foreach ($productAttributes as $key => $value) {
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

        if (!empty($productAttributes)) {
            $command->having('count("pa"."Id") = :CountAttributes', [':CountAttributes' => sizeof($productAttributes)]);
        }

        $result = $command->queryAll();

        $productIdList = [];
        foreach ($result as $value) {
            $productIdList[] = $value['Id'];
        }

        return $productIdList;
    }

    /**
     * @inheritdoc
     */
    protected function internalRollback(OrderItem $orderItem)
    {
        throw new MessageException(\Yii::t('app', 'Метод отката заказа не реализован для этого типа продукта'));
    }

    /**
     *
     * @param \user\models\User $fromUser
     * @param \user\models\User $toUser
     * @param array $params
     *
     * @return bool
     */
    public function internalChangeOwner($fromUser, $toUser, $params = [])
    {
        return true;
    }
}