<?php
namespace pay\models\forms;

class OrderForm extends \CFormModel
{
    const ScenarioRegisterUser = 'User';
    const ScenarioRegisterTicket = 'Ticket';

    public $Scenario;
    public $Items = [];

    public function rules()
    {
        return [
            ['Items,Scenario', 'safe']
        ];
    }
}
