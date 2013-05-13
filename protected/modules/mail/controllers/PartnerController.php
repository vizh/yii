<?php


class PartnerController extends \mail\components\MailerController
{
  /**
   * @return string
   */
  protected function getTemplateName()
  {
    return 'MBLT-08.05.2013_3';
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
    $test = true;
    $step = \Yii::app()->request->getParam('step', 0);
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);
    
    if (!$test)
    {
      $orderItems = \pay\models\OrderItem::model()->byEventId(431)
          ->byDeleted(false)->byPaid(false)->findAll();
      $idList = array();
      foreach ($orderItems as $item)
      {
        $idList[] = $item->PayerId;
      }

      $criteria = new \CDbCriteria();
      $criteria->addInCondition('"t"."Id"', $idList);
    }
    else
    {
      $criteria = new \CDbCriteria();
      $criteria->with = array(
        'Participants' => array('together' => true, 'select' => false)
      );
      $criteria->addInCondition('"t"."RunetId"', array(35287,454));
    }
    $criteria->limit  = $this->getStepCount();
    $criteria->offset = $this->getStepCount() * $step;

    $count = \user\models\User::model()->byVisible(true)->count($criteria);
    echo 'Получателей:'. $count.'<br/>';
    
    $users = \user\models\User::model()->byVisible(true)->findAll($criteria);
    $mailer = new \mail\components\Mailer();
    foreach ($users as $user)
    {
      $mail = new \mail\components\mail\Mblt13();
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
