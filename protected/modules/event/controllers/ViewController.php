<?php


class ViewController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($idName)
  {
    /** @var $event \event\models\Event */
    $event = \event\models\Event::model()
      ->byIdName($idName)
      ->with(array('Attributes', 'Widgets'))->find();
    if (empty($event))
    {
      throw new CHttpException(404);
    }

    foreach ($event->Widgets as $widget)
    {
      $widget->getWidget()->process();
    }

    $this->render('index');
  }
}