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
        if ($this->mailer == null) {
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
//    exit;

        $test = true;
        set_time_limit(84600);
        error_reporting(E_ALL & ~E_DEPRECATED);

        /** ВХОЖДЕНИЕ ДЛЯ БОЕВОЙ РАССЫЛКИ */
        if (!$test) {
            //$builder = new \mail\components\Builder();
            //$builder->addEvent(391);
            //$builder->addEvent(452);
            //$criteria = $builder->getCriteria();
            $criteria = new CDbCriteria();
        } /** ВХОЖДЕНИЕ ДЛЯ ТЕСТИРОВАНИЯ */
        else {
            $criteria = new \CDbCriteria();
            $criteria->addInCondition('"t"."RunetId"', [12953]);
        }
        $criteria->limit = $this->getStepCount();
        $criteria->offset = $this->getStepCount() * $step;

//    $count = \user\models\User::model()->byVisible(true)->count($criteria);
//    echo 'Получателей:'. $count.'<br/>';
//    exit;

        $users = \user\models\User::model()->byVisible(true)->findAll($criteria);

        foreach ($users as $user) {
            $mail = new \mail\components\mail\Download13($this->getMailer(), $user);
            $mail->send();
        }

        if (!empty($users)) {
            echo '<meta http-equiv="refresh" content="3; url='.$this->createUrl('/mail/partner/send', ['step' => ($step + 1)]).'">';
        } else {
            echo 'Рассылка ушла';
        }
        Yii::app()->end();
    }

}
