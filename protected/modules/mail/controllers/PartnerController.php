<?php


class PartnerController extends \mail\components\MailerController
{
  /**
   * @return string
   */
  protected function getTemplateName()
  {
    return 'phdays1';
  }

  /**
   * @return int
   */
  protected function getStepCount()
  {
    return 100;
  }

  public function actionSend($step = 0)
  {
    return;
    $step = \Yii::app()->request->getParam('step', 0);
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $builder = new \mail\components\Builder();
    $builder->addEvent(246);
    $builder->addEvent(195);
    $builder->addEvent(120);
    //$builder->addEvent(411);
    //$builder->addEvent(246);
    
    $criteria = $builder->getCriteria();
    $criteria->limit  = $this->getStepCount();
    $criteria->offset = $this->getStepCount() * $step;

    $count = \user\models\User::model()->byVisible(true)->count($criteria);
    echo 'Получателей:'. $count.'<br/>';

    $users = \user\models\User::model()->byVisible(true)->findAll($criteria);
    $mailer = new \mail\components\Mailer();
    foreach ($users as $user)
    {
      $mail = new \mail\components\mail\PhDays13();
      $mail->user = $user;
      $mailer->send($mail, $user->Email);
      $this->addLogMessage($user->RunetId.' '.$user->Email);
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