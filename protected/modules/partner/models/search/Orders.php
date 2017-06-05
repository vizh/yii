<?php
/**
 * Created by PhpStorm.
 * User: Андрей
 * Date: 05.06.2015
 * Time: 18:37
 */

namespace application\modules\partner\models\search;

use application\components\form\SearchFormModel;
use event\models\Event;
use pay\models\Order;
use pay\models\OrderJuridical;
use pay\models\OrderType;
use user\models\User;

class Orders extends SearchFormModel
{
    const STATUS_DEFAULT = 'default';
    const STATUS_PAID = 'paid';
    const STATUS_DELETED = 'deleted';

    public $Number;

    public $Type;

    public $Payer;

    public $Status;

    public function rules()
    {
        return [
            ['Number, Payer', 'filter', 'filter' => '\application\components\utility\Texts::clear'],
            ['Status', 'in', 'range' => array_keys($this->getStatusData())],
            ['Type', 'safe']
        ];
    }

    /** @var Event */
    private $event;

    public function __construct(Event $event, $scenario = '')
    {
        parent::__construct($scenario);
        $this->event = $event;
    }

    /**
     * @return \CDataProvider
     */
    public function getDataProvider()
    {
        $model = Order::model()->byEventId($this->event->Id);
        return new \CActiveDataProvider($model, [
            'criteria' => $this->getCriteria(),
            'sort' => $this->getSort()
        ]);
    }

    /**
     * @return \CDbCriteria
     */
    private function getCriteria()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = [
            'ItemLinks.OrderItem' => ['together' => false],
            'Payer'
        ];

        if ($this->validate()) {
            if (!empty($this->Number)) {
                if (is_numeric($this->Number)) {
                    $criteria->addCondition('"t"."Id" = :Number');
                    $criteria->params['Number'] = $this->Number;
                }
                $criteria->addCondition('"t"."Number" ILIKE :LikeNumber', 'OR');
                $criteria->params['LikeNumber'] = '%'.$this->Number.'%';
            }

            if (!empty($this->Type)) {
                $criteria->addInCondition('"t"."Type"', $this->Type);
            }

            if (!empty($this->Status)) {
                if ($this->Status == self::STATUS_PAID) {
                    $criteria->addCondition('"t"."Paid"');
                } elseif ($this->Status == self::STATUS_DELETED) {
                    $criteria->addCondition('"t"."Deleted" AND NOT "t"."Paid"');
                } elseif ($this->Status == self::STATUS_DEFAULT) {
                    $criteria->addCondition('NOT "t"."Deleted" AND NOT "t"."Paid"');
                }
            }

            if (!empty($this->Payer)) {
                $criteria->mergeWith($this->getPayerCriteria());
            }
        }
        return $criteria;
    }

    /**
     * @return \CDbCriteria
     */
    private function getPayerCriteria()
    {
        $resultCriteria = new \CDbCriteria();

        $criteria = new \CDbCriteria();
        $criteria->with = ['Order'];
        $criteria->addCondition('"Order"."EventId" = :EventId AND ("t"."INN" ILIKE :INN OR "t"."Name" ILIKE :Name)');
        $criteria->params['EventId'] = $this->event->Id;
        $criteria->params['INN'] = '%'.$this->Payer.'%';
        $criteria->params['Name'] = '%'.$this->Payer.'%';

        $juridicals = OrderJuridical::model()->findAll($criteria);
        if (!empty($juridicals)) {
            $resultCriteria->addInCondition('"t"."Id"', \CHtml::listData($juridicals, 'Id', 'OrderId'));
        }

        $users = User::model()->bySearch($this->Payer, null, true, false)->byEmail($this->Payer, false)->findAll();
        if (!empty($users)) {
            $resultCriteria->addInCondition('"t"."PayerId"', \CHtml::listData($users, 'Id', 'Id'), 'OR');
        }
        return $resultCriteria;
    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'Number' => 'Номер счета',
            'Type' => 'Тип платежа',
            'Company' => 'Название компании',
            'INN' => 'ИНН компании',
            'Payer' => 'Плательщик',
            'CreationTime' => 'Дата создания',
            'Status' => 'Статус',
            'Price' => 'Сумма'
        ];
    }

    /**
     * @return array
     */
    public function getStatusData()
    {
        return [
            self::STATUS_DEFAULT => \Yii::t('app', 'Не оплачен'),
            self::STATUS_PAID => \Yii::t('app', 'Оплачен'),
            self::STATUS_DELETED => \Yii::t('app', 'Удален')
        ];
    }

    /**
     * @return array
     */
    public function getTypeData()
    {
        return [
            OrderType::Juridical => OrderType::getTitle(OrderType::Juridical),
            OrderType::Receipt => OrderType::getTitle(OrderType::Receipt),
            OrderType::PaySystem => OrderType::getTitle(OrderType::PaySystem)
        ];
    }

    /**
     * @return \CSort
     */
    public function getSort()
    {
        $sort = new \CSort();
        $sort->defaultOrder = ['CreationTime' => true];
        $sort->attributes = [
            'Number',
            'CreationTime'
        ];
        return $sort;
    }
}