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
            ['Order, Company, INN, Payer, Paid, Deleted', 'safe']
        ];
    }

    public function attributeLabels() {
        return [
            'Order' => 'Номер счета',
            'Company' => 'Название компании',
            'INN' => 'ИНН компании',
            'Payer' => 'Плательщик',
            'Paid' => 'Оплачен',
            'Deleted' => 'Показывать удаленные'
        ];
    }

    public function getListValues() {
        return [
            '' => '',
            1  => 'Да',
            0  => 'Нет',
        ];
    }
}