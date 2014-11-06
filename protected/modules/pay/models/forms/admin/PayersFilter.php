<?php
namespace pay\models\forms\admin;

use pay\models\Order;

class PayersFilter extends \CFormModel
{
    public $EventLabel;
    public $EventId;
    public $Paid;

    public function rules()
    {
        return [
            ['EventLabel, EventId', 'required'],
            ['EventId', 'exist', 'attributeName' => 'Id', 'className' => '\event\models\Event'],
            ['Paid', 'in', 'range' => array_keys($this->getPaidValues()), 'allowEmpty' => true]
        ];
    }

    public function attributeLabels()
    {
        return [
            'EventId' => \Yii::t('app', 'ID мероприятия'),
            'EventLabel' => \Yii::t('app', 'Название мероприятия'),
            'Paid' => \Yii::t('app', 'Оплачен'),
        ];
    }

    public function getPaidValues()
    {
        return ['' => '', 'yes' => 'Да', 'no' => 'Нет'];
    }

    /**
     * @return int[]
     */
    public function getUsers()
    {
        $model = Order::model();
        switch ($this->Paid) {
            case 'yes':
                $model->byPaid(true);
                break;
            case 'no':
                $model->byPaid(false)->byDeleted(false);
                break;
            default:
                $model->byPaid(true)->byDeleted(false, false);
                break;
        }
        $model->byEventId($this->EventId)->byBankTransfer(true);

        $orders = $model->findAll();
        $users = [];
        foreach ($orders as $order) {
            $users[] = $order->Payer->RunetId;
        }
        return $users;
    }
} 