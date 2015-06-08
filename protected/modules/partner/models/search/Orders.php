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

class Orders extends SearchFormModel
{
    public $Number;
    public $Type;
    public $Payer;
    public $Status;


    /** @var Event  */
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

        ]);
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
}