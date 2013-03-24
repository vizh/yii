<?php
namespace partner\controllers\main;

class IndexAction extends \partner\components\Action
{

  public function run()
  {
    $this->getController()->setPageTitle('Партнерский интерфейс');
    $this->getController()->initActiveBottomMenu('index');


    /** @var $roles \event\models\Role[] */
    $roles = \event\models\Role::model()
        ->byEventId(\Yii::app()->partner->getAccount()->EventId)->findAll();

    $statistics = null;
    if (sizeof(\Yii::app()->partner->getEvent()->Parts) === 0)
    {
      $statistics = $this->getSingleStatistics();
    }
    else
    {
      $statistics = $this->getManyPartsStatistics();
    }

    $this->getController()->render('index', array(
      'roles' => $roles,
      'statistics' => $statistics,
      'event' => \Yii::app()->partner->getEvent())
    );
  }

  protected function getSingleStatistics()
  {
    $event = \Yii::app()->partner->getEvent();
    $statistics = array();

    $criteria = new \CDbCriteria();
    $criteria->select = '"t"."RoleId", Count(*) as "CountForCriteria"';
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params['EventId'] = $event->Id;
    $criteria->group = '"t"."RoleId"';


    $participants = \event\models\Participant::model()->findAll($criteria);
    $statistics['Total'] = 0;
    foreach ($participants as $participant)
    {
      $statistics['Count'][$participant->RoleId] = $participant->CountForCriteria;
      $statistics['Total'] += $participant->CountForCriteria;
    }

    $criteria->addCondition('"t"."CreationTime" >= :CreationTime');
    $criteria->params['CreationTime'] = date('Y-m-d H:i:s', time() - 24*60*60);
    $participants = \event\models\Participant::model()->findAll($criteria);
    $statistics['TotalToday'] = 0;
    foreach ($participants as $participant)
    {
      $statistics['CountToday'][$participant->RoleId] = $participant->CountForCriteria;
      $statistics['TotalToday'] += $participant->CountForCriteria;
    }

    $criteria->params['CreationTime'] = date('Y-m-d H:i:s', time() - 7*24*60*60);;
    $participants = \event\models\Participant::model()->findAll($criteria);
    $statistics['TotalWeek'] = 0;
    foreach ($participants as $participant)
    {
      $statistics['CountWeek'][$participant->RoleId] = $participant->CountForCriteria;
      $statistics['TotalWeek'] += $participant->CountForCriteria;
    }

    return $statistics;
  }

  protected function getManyPartsStatistics()
  {
    $event = \Yii::app()->partner->getEvent();
    $statistics = array();

    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."EventId" = :EventId';
    $criteria->params['EventId'] = $event->Id;
    $criteria->group = '"t"."PartId", "t"."RoleId"';
    $criteria->select = '"t"."PartId", "t"."RoleId", Count(*) as "CountForCriteria"';
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $statistics[$participant->PartId]['Count'][$participant->RoleId] = $participant->CountForCriteria;
      if (!isset($statistics[$participant->PartId]['Total']))
      {
        $statistics[$participant->PartId]['Total'] = 0;
      }
      $statistics[$participant->PartId]['Total'] += $participant->CountForCriteria;
    }

    $criteria->addCondition('"t"."CreationTime" >= :CreationTime');
    $criteria->params['CreationTime'] = date('Y-m-d H:i:s', time() - 24*60*60);
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $statistics[$participant->PartId]['CountToday'][$participant->RoleId] = $participant->CountForCriteria;
      if (!isset($statistics[$participant->PartId]['TotalToday']))
      {
        $statistics[$participant->PartId]['TotalToday'] = 0;
      }
      $statistics[$participant->PartId]['TotalToday'] += $participant->CountForCriteria;
    }

    $criteria->params['CreationTime'] = date('Y-m-d H:i:s', time() - 7*24*60*60);;
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $statistics[$participant->PartId]['CountWeek'][$participant->RoleId] = $participant->CountForCriteria;
      if (!isset($statistics[$participant->PartId]['TotalWeek']))
      {
        $statistics[$participant->PartId]['TotalWeek'] = 0;
      }
      $statistics[$participant->PartId]['TotalWeek'] += $participant->CountForCriteria;
    }

    return $statistics;
  }
}
