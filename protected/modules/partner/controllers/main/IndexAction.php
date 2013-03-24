<?php
namespace partner\controllers\main;

class IndexAction extends \partner\components\Action
{
  private

  public function run()
  {
    $this->getController()->setPageTitle('Партнерский интерфейс');
    $this->getController()->initActiveBottomMenu('index');


    /** @var $roles \event\models\Role[] */
    $roles = \event\models\Role::model()
        ->byEventId(\Yii::app()->partner->getAccount()->EventId)->findAll();





    // Подсчет участников
    $todayTime  = mktime(0, 0, 0, date('n'), date('j'), date('Y'));
    $mondayTime = date('Y-m-d H:i:s', $todayTime - ((date('N')-1) * 86400));
    $todayTime  = date('Y-m-d H:i:s', $todayTime);
    if (!empty($event->Days))
    {

    }
    else
    {

    }

    $this->render('index',array('stat' => $stat, 'event' => $event));
  }

  protected function getOnePartStatistics()
  {
    //// Мероприятие на 1 день
    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params['EventId'] = $event->EventId;
    $criteria->group = 't.RoleId';
    $criteria->select = 't.RoleId, Count(*) as CountForCriteria';
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $stat->Participants[$participant->RoleId]->Count = $participant->CountForCriteria;
    }

    //// Прирост за неделю
    $criteria->addCondition('t.CreationTime >= :CreationTime');
    $criteria->params['CreationTime'] = $mondayTimeStamp;
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $stat->Participants[$participant->RoleId]->CountWeek = $participant->CountForCriteria;
    }

    //// Прирост за сегодня
    $criteria->params['CreationTime'] = $todayTimestamp;
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $stat->Participants[$participant->RoleId]->CountToday = $participant->CountForCriteria;
    }
  }

  protected function getManyPartsStatistics()
  {
    //// Мероприятие на несколько дней
    $criteria = new CDbCriteria();
    $criteria->condition = 't.EventId = :EventId';
    $criteria->params['EventId'] = $event->EventId;
    $criteria->group = 't.DayId, t.RoleId';
    $criteria->select = 't.DayId, t.RoleId, Count(*) as CountForCriteria';
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $stat->Participants[$participant->DayId][$participant->RoleId]->Count = $participant->CountForCriteria;
    }

    //// Прирост за неделю
    $criteria->addCondition('t.CreationTime >= :CreationTime');
    $criteria->params['CreationTime'] = $mondayTimeStamp;
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $stat->Participants[$participant->DayId][$participant->RoleId]->Count = $participant->CountForCriteria;
    }

    //// Прирост за сегодня
    $criteria->params['CreationTime'] = $todayTimestamp;
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $stat->Participants[$participant->DayId][$participant->RoleId]->Count = $participant->CountForCriteria;
    }
  }
}
