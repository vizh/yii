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

    $this->setPageTitle($event->Title . '  / RUNET-ID');

    foreach ($event->Widgets as $widget)
    {
      $widget->process();
    }

    $this->render('index', array('event' => $event));
  }

  public function actionUsers($idName, $term = '')
  {
    $textUtility = new \application\components\utility\Texts();
    $term = $textUtility->filterPurify(trim($term));

    /** @var $event \event\models\Event */
    $event = \event\models\Event::model()->byIdName($idName)
        ->with(array('Attributes', 'Widgets'))->find();;
    if (empty($event))
    {
      throw new CHttpException(404);
    }

    $criteria = new \CDbCriteria();
    if (!empty($term))
    {
      $criteria->mergeWith(
        \user\models\User::model()->bySearch($term)->getDbCriteria()
      );
    }
    
    $users = $this->widget('\event\widgets\Users', array(
      'event' => $event, 
      'showCounter' => false, 
      'showPagination' => true,
      'criteria' => $criteria
    ), true);
    
    $this->setPageTitle($event->Title . '  / RUNET-ID');
    $this->render('users', array(
      'event'     => $event,
      'users'     => $users
    ));
  }
}