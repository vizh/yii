<?php
class TicketController extends application\components\controllers\PublicMainController
{
  public $layout = '//layouts/ticket';
  
  public function actionIndex($eventIdName, $runetId, $hash)
  {
    $event = \event\models\Event::model()->byIdName($eventIdName)->find();
    $user  = \user\models\User::model()->byRunetId($runetId)->find();
    
    if ($event == null || $user == null)
      throw new \CHttpException(404);
    
    $participant = \event\models\Participant::model()->byUserId($user->Id)->byEventId($event->Id)->find();
    if ($participant == null || $participant->getHash() !== $hash)
      throw new \CHttpException(404);
    
    $path = \Yii::getPathOfAlias('event.views.ticket.'.$event->IdName).'.php';
    $view = file_exists($path) ? $event->IdName : 'index';
    $this->setPageTitle(\Yii::t('app', 'Ваш билет на мероприятие «{event}»', ['{event}' => $event->Title]));
    \Yii::app()->getClientScript()->reset();
    $this->render($view, ['event' => $event, 'role' => $participant->Role, 'user' => $user]);
  }
}
