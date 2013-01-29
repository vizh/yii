<?php
class ViewController extends \application\components\controllers\PublicMainController
{
  public function actionIndex($runetId)
  {
    $criteria = new \CDbCriteria();
    $criteria->with = array(
      'Settings',
      'LinkAddress.Address.City',
      'LinkSite.Site',
      'LinkServiceAccounts.ServiceAccounts.Type',
      'Employment.Company',
      'Participants.Event',
      'Participants.Role'
    );
    $user = \user\models\User::model()->byRunetId($runetId)->byVisible()->find();
    if ($user == null)
    {
      throw new \CHttpException(404);
    }
    
    
    $tmpParticipants = $user->Participants;
    $participants = array();
    foreach ($tmpParticipants as $participant)
    {
      if (!isset($participants[$participant->EventId]))
      {
        $participants[$participant->EventId]->Event = $participant->Event;
      }
      $participants[$participant->EventId]->Roles[] = $participant->Role;
    }
    
    
    \Yii::app()->clientScript->registerPackage('runetid.charts');
    $this->bodyId = 'user-account';
    $this->render('index', array(
      'user' => $user, 
      'participants' => $participants
    ));
  }
}

?>
