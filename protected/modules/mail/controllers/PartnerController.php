<?php


class PartnerController extends \mail\components\MailerController
{
  /**
   * @return string
   */
  protected function getTemplateName()
  {
    return 'MBLT-13.05.2013';
  }

  /**
   * @return int
   */
  protected function getStepCount()
  {
    return 300;
  }

  public function actionSend($step = 0)
  {
    return;
    $test = false;
    $step = \Yii::app()->request->getParam('step', 0);
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);
    
    if (!$test)
    {
      $criteria = new \CDbCriteria();
      $criteria->with = array(
        'LinkAddress.Address' => array('together' => true)
      );
      $builder = new \mail\components\Builder();
      $builder->addEvent(115);
      $builder->addEvent(176);
      $builder->addEvent(258);
      $builder->addEvent(423);
      $criteria->mergeWith($builder->getCriteria());
      $criteria->addInCondition('"Address"."RegionId"', array(3892,3994,3251,3503,4481,4925,4503,4773,3761), 'OR');
      
      $eventParticipants = \event\models\Participant::model()->byEventId(423)->findAll();
      $excludedUserIdList = array();
      foreach ($eventParticipants as $eventParticipant)
      {
        $excludedUserIdList[] = $eventParticipant->UserId;
      }
      $criteria->addNotInCondition('"t"."Id"', $excludedUserIdList);
    }
    else
    {
      $criteria = new \CDbCriteria();
      $criteria->addInCondition('"t"."RunetId"', array(321,454));
    }
    $criteria->limit  = $this->getStepCount();
    $criteria->offset = $this->getStepCount() * $step;

    $count = \user\models\User::model()->byVisible(true)->count($criteria);
    echo 'Получателей:'. $count.'<br/>';
    
    $users = \user\models\User::model()->byVisible(true)->findAll($criteria);
    $mailer = new \mail\components\Mailer();
    foreach ($users as $user)
    {
      $mail = new \mail\components\mail\SPIC13();
      $mail->user = $user;
      $mailer->send($mail, $user->Email, false);
      if (!$test)
      {
        $this->addLogMessage($user->RunetId.' '.$user->Email);
      }
    }
    if (!empty($users))
    {
      echo '<meta http-equiv="refresh" content="3; url='.$this->createUrl('/mail/partner/send', array('step' => ($step+1))).'">';
    }
    else
    {
      echo 'Рассылка ушла';
    }
    Yii::app()->end();
  }
}