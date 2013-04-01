<?php
namespace ruvents\controllers\event;

class SettingsAction extends \ruvents\components\Action
{
  public function run()
  {
    //todo:

    throw new \application\components\Exception('Not implement yet');

    $event = \event\models\Event::GetById($this->Operator()->EventId);
    if (empty($event))
    {
      throw new \ruvents\components\Exception(301);
    }

    $result = array('Settings' => array());
    $settings = \ruvents\models\EventSetting::model()->byEventId($event->EventId)->findAll();
    foreach ($settings as $setting)
    {
      $result['Settings'][] = $this->DataBuilder()->{$setting->DataBuilder}($setting);
    }
    echo json_encode($result);
  }
}
