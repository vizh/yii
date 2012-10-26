<?php
namespace partner\controllers\user;

class StatisticsAction extends \partner\components\Action
{
  private $newUserIdList = array();

  /** @var \event\models\Participant[] */
  private $newParticipants;

  /** @var array */
  private $duplicates = array();

  public function run()
  {
    ini_set("memory_limit", "512M");

    $this->getController()->setPageTitle('Статистика регистраций участников');
    $this->getController()->initActiveBottomMenu('statistics');
    $this->fillNewUsers();
    $counter = $this->checkDuplicate();
    $this->getController()->render('statistics', array(
        'duplicates' => $this->duplicates,
        'newCount' => sizeof($this->newParticipants),
        'counter' => $counter
      )
    );

    echo \Yii::getLogger()->getExecutionTime();
  }

  private function fillNewUsers()
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array('User' => array('together' => true));
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
    $counter = 0;
    foreach ($this->newParticipants as $participant)
    {
      $counter++;
      if (\Yii::getLogger()->getExecutionTime() > 25)
      {
        return $counter;
      }
      $criteria = new \CDbCriteria();
      $criteria->addCondition('t.LastName = :LastName');
      $criteria->addCondition('t.FirstName = :FirstName');
      $criteria->addCondition('t.UserId != :UserId');
      $criteria->params = array(
        'LastName' => $participant->User->LastName,
        'FirstName' => $participant->User->FirstName,
        'UserId' => $participant->UserId
      );

      /** @var $users \user\models\User[] */
      $users = \user\models\User::model()->with('Employments', 'Employments.Company')->findAll($criteria);
      if (sizeof($users) > 0)
      {
        $employment = $participant->User->EmploymentPrimary();
        if (empty($employment))
        {
          continue;
        }
        $name = $employment->Company->Name;
        foreach ($users as $user)
        {
          foreach ($user->Employments as $employment)
          {
            if ($name == $employment->Company->Name)
            {
              $this->duplicates[$participant->User->RocId]['Current'] = $participant;
              $this->duplicates[$participant->User->RocId]['Check'][] = $user;
              break;
            }
          }
        }
      }
    }
    return $counter;
  }
}
