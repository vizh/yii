<?php
namespace partner\controllers\user;

class StatisticsAction extends \partner\components\Action
{
  private $newUserIdList = array();

  /** @var \event\models\Participant[] */
  private $newParticipants;

  public function run()
  {
    $this->getController()->setPageTitle('Статистика регистраций участников');
    $this->getController()->initActiveBottomMenu('statistics');
    $this->fillNewUsers();

    $this->checkDuplicate();


    $this->getController()->render('statistics');
  }

  private function fillNewUsers()
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array('User' => array('together' => true, 'select' => false));
    $criteria->addCondition('t.CreationTime < (User.CreationTime + 3600)');

    $participant = \event\models\Participant::model()->byEventId(\Yii::app()->partner->getAccount()->EventId);

    /** @var $participants \event\models\Participant[] */
    $this->newParticipants = $participant->findAll($criteria);
    foreach ($this->newParticipants as $participant)
    {
      $this->newUserIdList[] = $participant->UserId;
    }
  }

  private function checkDuplicate()
  {
    foreach ($this->newParticipants as $participant)
    {
      $criteria = new \CDbCriteria();
      $criteria->addCondition('t.LastName = :LastName');
      $criteria->addCondition('t.FirstName = :FirstName');
      $criteria->params = array(
        'LastName' => $participant->User->LastName,
        'FirstName' => $participant->User->FirstName
      );

      $count = \user\models\User::model()->count($criteria);
      if ($count > 0)
      {
        echo $count . ' ' . $participant->User->RocId . '<br>';
      }
    }
  }
}
