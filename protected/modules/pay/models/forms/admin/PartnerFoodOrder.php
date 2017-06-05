<?php
namespace pay\models\forms\admin;

use application\helpers\Flash;
use pay\models\FoodPartnerOrder;
use pay\models\FoodPartnerOrderItem;
use pay\models\Product;

class PartnerFoodOrder extends BasePartnerOrder
{
    public $Owner = null;
    public $ProductIdList;

    /**
     * @param string $owner
     * @param FoodPartnerOrder $model
     */
    public function __construct($owner = null, FoodPartnerOrder $model = null)
    {
        parent::__construct($owner, $model);
        if ($model !== null) {
            foreach ($model->Items as $item) {
                $this->ProductIdList[$item->ProductId] = $item->Count;
            }
        }
    }

    /**
     * @return array
     */
    public function rules()
    {
        $rules = [];
        if ($this->getOwner() == null) {
            $rules[] = ['Owner', 'required'];
        }
        $rules[] = ['ProductIdList', 'validateProductIdList'];
        return array_merge(parent::rules(), $rules);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $labels = [
            'Owner' => \Yii::t('app', 'Партнер')
        ];
        return array_merge($labels, parent::attributeLabels());
    }

    /**
     * @return \CActiveRecord|null
     * @throws \application\components\Exception
     */
    public function createActiveRecord()
    {
        $eventId = \Yii::app()->params['AdminBookingEventId'];
        $number = FoodPartnerOrder::model()->byEventId($eventId)->count() + 1;

        $order = new FoodPartnerOrder();
        $order->Number = ('RIF17/'.str_pad($number, 3, '0', STR_PAD_LEFT).'-F');
        $order->EventId = $eventId;
        if ($this->getOwner() !== null) {
            $order->Owner = $this->getOwner();
        }
        $this->model = $order;
        return $this->updateActiveRecord();
    }

    /**
     * @return CActiveRecord|null
     * @throws \CDbException
     */
    public function updateActiveRecord()
    {
        if (!$this->validate()) {
            return null;
        }

        $transaction = \Yii::app()->getDb()->beginTransaction();
        try {
            $this->fillActiveRecord();
            $this->model->save();

            foreach ($this->ProductIdList as $id => $count) {
                $orderItem = FoodPartnerOrderItem::model()->byOrderId($this->model->Id)->byProductId($id)->find();
                if ($orderItem === null) {
                    if ($count == 0) {
                        continue;
                    }
                    $orderItem = new FoodPartnerOrderItem();
                    $orderItem->ProductId = $id;
                    $orderItem->OrderId = $this->model->Id;
                }
                $orderItem->Count = $count;
                $orderItem->save();
            }
            $transaction->commit();
            return $this->model;
        } catch (\CDbException $e) {
            $transaction->rollBack();
            Flash::setError($e);
        }
        return null;
    }

    /**
     * @param string $attribute
     */
    public function validateProductIdList($attribute)
    {
        $value = $this->$attribute;

        $valid = false;
        foreach ($value as $id => $count) {
            $exists = Product::model()->byEventId(\Yii::app()->params['AdminBookingEventId'])->byId($id)->exists();
            if ($count > 0 && $exists) {
                $valid = true;
            }
        }

        if (!$valid) {
            $this->addError($attribute, 'Укажите требуемое кол-во товаров.');
        }
    }

    /**
     * @return array
     */
    public static function getFoodProductData()
    {
        $data = [
            '2017-04-18' => [
                7246 => 'Ужин',
            ],
            '2017-04-19' => [
                7247 => 'Завтрак',
                7248 => 'Обед',
                7249 => 'Ужин',
            ],
            '2017-04-20' => [
                7250 => 'Завтрак',
                7251 => 'Обед',
                7252 => 'Ужин'
            ],
            '2017-04-21' => [
                7253 => 'Завтрак',
                7254 => 'Обед',
                7255 => 'Ужин'
            ],
        ];
        return $data;
    }

}
