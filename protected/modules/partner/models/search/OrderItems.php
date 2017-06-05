<?php
namespace partner\models\search;

use application\components\form\SearchFormModel;
use event\models\Event;
use pay\models\OrderItem;
use pay\models\Product;
use user\models\User;

class OrderItems extends SearchFormModel
{
    const STATUS_DEFAULT = 'default';
    const STATUS_PAID = 'paid';
    const STATUS_DELETED = 'deleted';
    const STATUS_REFUND = 'refund';

    public $Id;

    public $Product;

    public $Payer;

    public $Owner;

    public $Status;

    /** @var Event */
    private $event;

    public function __construct(Event $event)
    {
        $this->event = $event;
        parent::__construct();
    }

    public function rules()
    {
        return [
            ['Id,Payer,Owner,Status', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Product', 'safe']
        ];
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        $model = OrderItem::model()->byEventId($this->event->Id);
        return new \CActiveDataProvider($model, [
            'criteria' => $this->getCriteria(),
            'sort' => $this->getSort()
        ]);
    }

    /**
     * @return \CDbCriteria
     */
    public function getCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = ['Payer', 'Owner', 'OrderLinks'];
        if ($this->validate()) {
            if (!empty($this->Id)) {
                $criteria->addCondition('"t"."Id" = :Id');
                $criteria->params['Id'] = $this->Id;
            }

            if (!empty($this->Product)) {
                $criteria->addInCondition('"t"."ProductId"', $this->Product);
            }

            if (!empty($this->Payer)) {
                $users = User::model()->bySearch($this->Payer, null, true, false)->byEmail($this->Payer, false)->findAll();
                $criteria->addInCondition('"t"."PayerId"', \CHtml::listData($users, 'Id', 'Id'));
            }

            if (!empty($this->Owner)) {
                $users = User::model()->bySearch($this->Owner, null, true, false)->byEmail($this->Owner, false)->findAll();
                if (!empty($users)) {
                    $list = implode(',', \CHtml::listData($users, 'Id', 'Id'));
                    $criteria->addCondition('"t"."ChangedOwnerId" IN ('.$list.') OR ("t"."ChangedOwnerId" IS NULL AND "t"."OwnerId" IN ('.$list.'))');
                } else {
                    $criteria->addCondition('1=2');
                }
            }

            if (!empty($this->Status)) {
                if ($this->Status == self::STATUS_PAID) {
                    $criteria->addCondition('"t"."Paid"');
                } elseif ($this->Status == self::STATUS_REFUND) {
                    $criteria->addCondition('"t"."Refund"');
                } elseif ($this->Status == self::STATUS_DELETED) {
                    $criteria->addCondition('"t"."Deleted" AND NOT "t"."Paid"');
                } else {
                    $criteria->addCondition('NOT "t"."Deleted" AND NOT "t"."Paid"');
                }
            }
        }
        return $criteria;
    }

    /**
     * @return \CSort
     */
    public function getSort()
    {
        $sort = new \CSort();
        $sort->attributes = [
            'Id',
            'Payer' => [
                'asc' => '"Payer"."RunetId" ASC',
                'desc' => '"Payer"."RunetId" DESC'
            ],
            'Owner' => [
                'asc' => '"Owner"."RunetId" ASC',
                'desc' => '"Owner"."RunetId" DESC'
            ],
            'CreationTime'
        ];
        $sort->defaultOrder = ['CreationTime' => true];
        return $sort;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Id' => 'Номер элемента заказа',
            'Product' => 'Товар',
            'Payer' => 'Плательщик',
            'Owner' => 'Получатель',
            'Status' => 'Статус',
            'CreationTime' => 'Дата создания',
            'Total' => 'Сумма',
            'PaidType' => 'Тип оплаты'
        ];
    }

    /**
     * return string[]
     */
    public function getProductData()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = '"t"."Title" ASC';
        $criteria->addNotInCondition('"t"."ManagerName"', ['RoomProductManager']);
        $products = Product::model()->byEventId($this->event->Id)->byDeleted(false)->findAll($criteria);
        return \CHtml::listData($products, 'Id', 'Title');
    }

    /**
     * @return array
     */
    public function getStatusData()
    {
        return [
            self::STATUS_DEFAULT => \Yii::t('app', 'Не оплачен'),
            self::STATUS_PAID => \Yii::t('app', 'Оплачен'),
            self::STATUS_DELETED => \Yii::t('app', 'Удален'),
            self::STATUS_REFUND => \Yii::t('app', 'Возврат')
        ];
    }
}