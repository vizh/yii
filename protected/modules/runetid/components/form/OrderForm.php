<?php
namespace runetid\components\form;

class OrderForm extends \CFormModel
{
    public $Count;
    public $Owners;
    public $PromoCodes;

    public function rules()
    {
        return [
            ['Count, Owners, PromoCodes', 'safe']
        ];
    }
}

