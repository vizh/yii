<?php
namespace api\controllers\event;

class StatisticsAction extends \api\components\Action
{
  public function run()
  {
    $criteria = new \CDbCriteria();
    $criteria->select = '"t"."RoleId", Count(*) as "CountForCriteria"';
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params['EventId'] = $this->getEvent()->Id;
    $criteria->group = '"t"."RoleId"';


    $participants = \event\models\Participant::model()->findAll($criteria);
    $statistics['Total'] = 0;
    $total = 0;
    $result = array();
    foreach ($participants as $participant)
    {
      $resultRole = $this->getDataBuilder()->createRole($participant->Role);
      $resultRole->Count = $participant->CountForCriteria;
      $result['Roles'][] = $resultRole;
      $total += $participant->CountForCriteria;
    }

    $result['Total'] = $total;

    $this->setResult($result);
  }
}