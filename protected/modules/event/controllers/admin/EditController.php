<?php
class EditController extends \application\components\controllers\AdminMainController
{
  public function actionIndex($eventId = null)
  {
    if ($eventId !== null)
    {
      $event = \event\models\Event::model()->findByPk($eventId);
    }
    else 
    {
      $event = new \event\models\Event();
    }
    
    $widgets = array();
    foreach (\Yii::app()->params['EventWidgets'] as $class)
    {
      $this->createWidget('\event\widgets\Adv');
      //$widget = \Yii::app()->getController()->createWidget($class, array('event' => $event));
    }
    
    
    $form = new \event\models\forms\admin\EditForm();
    $this->render('index', array('form' => $form, 'event' => $event, 'widgets' => $widgets));
  }
}
