<?php
class TestController extends \CController
{
  public function actionPhoto()
  {
    $limit = 50; 
    $step  = \Yii::app()->request->getParam('step', 0);
    $criteria = new \CDbCriteria();
    $criteria->order  = '"t"."Id" ASC';
    $criteria->limit  = $limit;
    $criteria->offset = $limit * $step;
    $events = \event\models\Event::model()->findAll($criteria);
    if (!empty($events))
    {
      foreach ($events as $event)
      {
        echo 'Для '.$event->IdName.' ';
        $logoPath = \Yii::getPathOfAlias('webroot').'/files/event/logo/event_' . $event->IdName . '.png';
        if (file_exists($logoPath))
        {
          $logo = new \event\models\Logo2($event->IdName);
          $logo->save($logoPath);
          echo 'создан логотип';
        }
        else
        {
          echo 'файл не найден';
        }
        echo '<br/>';
      }
      echo '<meta http-equiv="refresh" content="5; url='.$this->createUrl('/main/test/photo', array('step' => ($step+1))).'">"';
    }
    else
    {
      echo 'Готово!';
    }
  }
}
