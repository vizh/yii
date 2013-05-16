<?php
namespace event\widgets;

use event\models\Participant;
use user\models\User;

class Users extends \event\components\Widget
{

  public function run()
  {
    $model = User::model()->byEventId($this->event->Id)->byVisible();
    $criteria = new \CDbCriteria();
    $criteria->order = '"Participants"."UpdateTime" DESC';
    $criteria->limit = $this->getCountUserPerPage();
    $criteria->offset = 0;
    $criteria->with = array('Employments');

    $users = $model->findAll($criteria);


    $this->render('users', array('users' => $users, 'count' => $this->getCount()));
  }

  /**
   * @return string
   */
  public function getTitle()
  {
    return \Yii::t('app', 'Список участников');
  }

  /**
   * @return string
   */
  public function getPosition()
  {
    return \event\components\WidgetPosition::Tabs;
  }

  public function getIsActive()
  {
    return $this->getCount() > 0;
  }


  /**
   * @return int
   */
  public function getCountUserPerPage()
  {
    return \Yii::app()->params['EventViewUserPerPage'];
  }
  /** @var  int */
  private $count = null;
  /**
   * @return int
   */
  protected function getCount()
  {
    if ($this->count === null)
    {
      $model = User::model()->byEventId($this->event->Id)->byVisible();
      $this->count = $model->count();
    }
    return $this->count;
  }
}
