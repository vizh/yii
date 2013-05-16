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
    $this->setPageTitle($event->Title . '  / RUNET-ID');

    $userModel = \user\models\User::model();
    $userModel->byEventId($event->Id);
    if (!empty($term))
    {
      $userModel->bySearch($term);
    }
    $paginator = new \application\components\utility\Paginator($userModel->count());
    $paginator->perPage = \Yii::app()->params['EventViewUserPerPage'] * 2;


    $userModel = \user\models\User::model();
    $userModel->byEventId($event->Id);
    if (!empty($term))
    {
      $userModel->bySearch($term);
    }
    $criteria = $paginator->getCriteria();
    $criteria->with = array(
      'Employments' => array('together' => false)
    );
    $users = $userModel->findAll($criteria);

    $this->render('users', array(
      'event' => $event,
      'users' => $users,
      'paginator' => $paginator
    ));
  }
}