<?php
namespace application\widgets\admin;

class Sidebar extends \CWidget
{
  public function run()
  {
    $counts = new \stdClass();
    $criteria = new \CDbCriteria();
    $criteria->condition = '"t"."External" = true AND "t"."Approved" = 0';
    $counts->Event = \event\models\Event::model()->count($criteria);
    $this->render('sidebar', array('counts' => $counts));
  }
}
