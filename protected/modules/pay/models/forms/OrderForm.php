<?php
namespace pay\models\forms;

class OrderForm extends \CFormModel
{
  const ScenarioRegisterUser   = 'User';
  const ScenarioRegisterTicket = 'Ticket';

  public $Scenario;
  public $Items = array();

  public function rules()
  {
    return array(
      array('Items,Scenario', 'safe')
    );
  }
}
