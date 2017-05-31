<?php
namespace pay\models;

use application\components\ActiveRecord;
use application\components\helpers\ArrayHelper;

/**
 * @property int $Id
 * @property int $ImportId
 * @property array $Data
 *
 * Описание вспомогательных методов
 * @method ImportOrder   with($condition = '')
 * @method ImportOrder   find($condition = '', $params = [])
 * @method ImportOrder   findByPk($pk, $condition = '', $params = [])
 * @method ImportOrder   findByAttributes($attributes, $condition = '', $params = [])
 * @method ImportOrder[] findAll($condition = '', $params = [])
 * @method ImportOrder[] findAllByAttributes($attributes, $condition = '', $params = [])
 *
 * @method ImportOrder byId(int $id, bool $useAnd = true)
 * @method ImportOrder byImportId(int $id, bool $useAnd = true)
 */
class ImportEntry extends ActiveRecord
{
    /**
     * @param null|string $className
     * @return static
     */
    public static function model($className = __CLASS__)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return parent::model($className);
    }

    public function tableName()
    {
        return 'PayOrderImportEntry';
    }

    public function relations()
    {
        return [
            'orders' => [self::HAS_MANY, ImportOrder::className(), 'EntryId']
        ];
    }

    public function beforeSave()
    {
        $this->Data = serialize($this->Data);
        return parent::beforeSave();
    }

    public function afterSave()
    {
        $this->Data = unserialize($this->Data);
        parent::afterSave();
    }

    public function afterFind()
    {
        $this->Data = unserialize($this->Data);
        parent::afterFind();
    }

    public function matchOrders()
    {
        $orders = [];
        $ids = $this->extractOrderIds(ArrayHelper::getValue($this->Data, 'НазначениеПлатежа', ''), ArrayHelper::getValue($this->Data, 'ПлательщикИНН', ''));
        foreach ($ids as $id) {
            $order = new ImportOrder();
            $order->EntryId = $this->Id;
            $order->OrderId = $id;
            $order->Approved = false;
            $order->save();
            $orders[] = $order;
        }
        $this->orders = $orders;
    }

    protected function extractOrderIds($text, $inn)
    {
        $ids = [];
        $parts = array_filter(preg_split('/[\s*]|счету|№/i', $text));
        foreach ($parts as $part) {
            $ids[] = $this->findOrder($part, $inn);
        }
        $ids = array_filter($ids);
        return $ids;
    }

    protected function findOrder($number, $inn)
    {
        $number = trim($number, '№');

        $criteria = new \CDbCriteria();
        $criteria->with[] = 'OrderJuridical';
        $criteria->addColumnCondition([
            '"Number"' => $number,
            '"OrderJuridical"."INN"' => $inn
        ]);

        $orders = Order::model()->findAll($criteria);
        if (count($orders) == 1) {
            return $orders[0]->Id;
        }
        return null;
    }
}
