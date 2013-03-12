<?php
class SectionController extends \application\components\controllers\AdminMainController
{
  protected function getCellId($hall, $time)
  {
    return $hall->Id.'_'.$time;
  }
  
  public function actionIndex($eventId)
  {
    $event = \event\models\Event::model()->findByPk($eventId);
    if ($event == null)
    {
      throw new CHttpException(404);
    }
    $this->render('index', array('event' => $event));
  }
}
