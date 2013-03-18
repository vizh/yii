<?php
namespace pay\components;

class Controller extends \application\components\controllers\PublicMainController
{
  public $layout = '/layouts/pay';

  /** @var \event\models\Event */
  protected $event = null;

  /**
   * @return \event\models\Event
   * @throws \CHttpException
   */
  public function getEvent()
  {
    if ($this->event === null)
    {
      $eventIdName = \Yii::app()->getRequest()->getParam('eventIdName');
      $this->event = \event\models\Event::model()->byIdName($eventIdName)->find();
      if ($this->event === null)
      {
        throw new \CHttpException(404);
      }
    }
    return $this->event;
  }

}
