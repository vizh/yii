<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 04.06.2015
 * Time: 19:48
 */

namespace application\modules\partner\models\search;

use application\components\form\SearchFormModel;
use event\models\Event;
use pay\models\Coupon;
use pay\models\CouponActivation;
use pay\models\Product;
use user\models\User;

class Coupons extends SearchFormModel
{
    public $Code;

    public $Discount;

    public $Owner;

    public $Product;

    /** @var Event */
    private $event;

    public function __construct(Event $event, $scenario = '')
    {
        parent::__construct($scenario);
        $this->event = $event;
    }

    public function rules()
    {
        return [
            ['Code, Discount, Owner', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Product', 'safe']
        ];
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        $model = Coupon::model()->byEventId($this->event->Id)->byDeleted(false);
        $this->fillCriteria($model);
        return new \CActiveDataProvider($model, [
            'sort' => $this->getSort()
        ]);
    }

    /**
     * @param Coupon $model
     * @return \CDbCriteria
     */
    private function fillCriteria(Coupon $model)
    {
        $criteria = new \CDbCriteria();
        if (!empty($this->Code)) {
            $model->byCode($this->Code);
        }

        if ($this->validate()) {
            if (!empty($this->Discount)) {
                $criteria->addCondition('"t"."Discount" = :Discount');
                $criteria->params['Discount'] = $this->Discount;
            }

            if (!empty($this->Product)) {
                $criteria->with['ProductLinks'] = [
                    'together' => true,
                    'select' => false
                ];
                $criteria->addInCondition('"ProductLinks"."ProductId"', $this->Product);
            }

            if (!empty($this->Owner)) {
                $criteria->mergeWith($this->getOwnerCriteria());
            }
        }

        $model->getDbCriteria()->mergeWith($criteria);
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Code' => 'Промо-код',
            'Discount' => 'Размер скидки (%)',
            'Product' => 'Товар',
            'Owner' => 'Получатель',
            'EndTime' => 'Срок действия'
        ];
    }

    /**
     * @return array
     */
    public function getProductData()
    {
        $criteria = new \CDbCriteria();
        $criteria->addCondition('"t"."ManagerName" != :ManagerName');
        $criteria->params['ManagerName'] = 'RoomProductManager';
        $products = Product::model()->byEventId($this->event->Id)->findAll($criteria);
        return \CHtml::listData($products, 'Id', 'Title');
    }

    /**
     * @return \CSort
     */
    private function getSort()
    {
        $sort = new \CSort();
        $sort->attributes = [
            'Code',
            'Discount'
        ];
        $sort->defaultOrder = ['Discount' => SORT_ASC];
        return $sort;
    }

    /**
     * @return \CDbCriteria
     */
    private function getOwnerCriteria()
    {
        $users = User::model()->bySearch($this->Owner, null, true, false)->byEmail($this->Owner, false)->findAll();
        $list = \CHtml::listData($users, 'Id', 'Id');

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."UserId"', $list);
        $activations = CouponActivation::model()->byEventId($this->event->Id)->findAll($criteria);

        $criteria = new \CDbCriteria();
        $criteria->addInCondition('"t"."OwnerId"', $list);
        $criteria->addInCondition('"t"."Id"', \CHtml::listData($activations, 'Id', 'CouponId'), 'OR');
        return $criteria;
    }
}