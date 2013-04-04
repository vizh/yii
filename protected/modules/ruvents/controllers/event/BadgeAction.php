<?php
namespace ruvents\controllers\event;

class BadgeAction extends \ruvents\components\Action
{
  public function run()
  {
    $event = $this->getEvent();
    /** @var $setting \ruvents\models\Setting */
    $setting = \ruvents\models\Setting::model()->byEventId($event->Id)->byName('badge')->find();

    $viewPath = '/badge/default';
    if ($setting !== null)
    {
      $viewPath = $setting->Value;
    }
    $badge = \Yii::app()->controller->renderPartial($viewPath, null, true);
    echo json_encode(array('Badge' => $badge));
  }
}
