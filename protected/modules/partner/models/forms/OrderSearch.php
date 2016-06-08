<?php
namespace partner\models\forms;

class OrderSearch extends \CFormModel
{
    public $Order;
    public $Company;
    public $INN;
    public $Payer;
    public $Paid;
    public $Deleted = null;

    public function rules() {
        return [
            ['Order, Company, Payer, Paid, Deleted', 'safe']
        ];
    }

    public function attributeLabels() {
        return [
            'Order' => 'Номер счета',
            'Company' => 'Название/ИНН компании',
            'Payer' => 'Плательщик',
            'Paid' => 'Показывать оплаченные',
            'Deleted' => 'Показывать удаленные'
        ];
    }
}