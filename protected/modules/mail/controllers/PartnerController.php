<?php


class PartnerController extends \mail\components\MailerController
{
  /**
   * @return string
   */
  protected function getTemplateName()
  {
    return 'phdays';
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
    $step = intval($step);
    set_time_limit(84600);
    error_reporting(E_ALL & ~E_DEPRECATED);

    $builder = new \mail\components\Builder();
    $builder->addEvent(246);
    $builder->addEvent(195);
    $builder->addEvent(120);

    $criteria = $builder->getCriteria();

    $count = \user\models\User::model()->byVisible(true)->count($builder->getCriteria());
    echo $count;

    Yii::app()->end();

  }



}