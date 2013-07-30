<?php


use mail\components\Mailer;

class PartnerController extends \mail\components\MailerController
{
  protected $mailer;

  /**
   * @return Mailer
   */
  protected function getMailer()
  {
    if ($this->mailer == null)
    {
      $this->mailer = new \mail\components\mailers\PhpMailer();
    }
    return $this->mailer;
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
    exit;

    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);
    
//    if (!$test)
//    {
//      $builder = new \mail\components\Builder();
//      $builder->addEvent(391);
//      $builder->addEvent(452);
//      $criteria = $builder->getCriteria();
//    }
//    else
//    {
//      $criteria = new \CDbCriteria();
//      $criteria->addInCondition('"t"."RunetId"', array(321, 454, 122262));
//    }
//    $criteria->limit  = $this->getStepCount();
//    $criteria->offset = $this->getStepCount() * $step;
    $runetIdList = [35287, 454];
    if (!$test)
    {
      $runetIdList = [90652, 126863, 105666, 127378, 120681, 103225, 92213, 41415, 114348, 30778, 107506, 114098, 127521, 127523, 126741, 79015, 84037, 107506, 107506, 127474, 127280, 127451, 127448, 78284, 127430, 127436, 30378, 126391, 127390, 109118, 92286, 127000, 17261, 17261, 127346, 127354, 105842, 127365, 127356, 127167, 127340, 127331, 83784, 127312, 79597, 127297, 127284, 106988, 127263, 120691, 105825, 127255, 13196, 97260, 104786, 105541, 127233, 99505, 127226, 104916, 127046, 127159, 126845, 120690, 127117, 127070, 126929, 24845, 107675, 126858, 20629, 104942, 126873, 124764, 126989, 123916, 126987, 95884, 86939, 118451, 106842, 101847, 36832, 105638, 124565, 124551, 82539, 30378, 114671, 1201, 84738, 125062, 27254, 595, 126155, 126448, 125052, 126597, 126565, 105666, 126687, 126334, 103753, 99695, 13233, 126518, 126759, 82617, 126820, 51662, 31754, 126829, 126771, 105666, 126391, 125750, 8923];
    }

    $criteria = new CDbCriteria();
    $criteria->addInCondition('"t"."RunetId"', $runetIdList);

    $count = \user\models\User::model()->byVisible(true)->count($criteria);
    echo 'Получателей:'. $count.'<br/>';

    exit;
    
    $users = \user\models\User::model()->byVisible(true)->findAll($criteria);

    foreach ($users as $user)
    {
      $mail = new \mail\components\mail\Riw13($this->getMailer(), $user);
      $mail->send();
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
