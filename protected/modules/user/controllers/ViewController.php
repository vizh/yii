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
      'LinkServiceAccounts.ServiceAccount.Type',
      'Employments.Company',
      'Participants' => array(
        'together' => false,
        'order' => '"Event"."Id" DESC'
      ),
      'Participants.Event',
      'Participants.Role',
      'Commissions' => array(
        'together' => false
      )
    );
    $user = \user\models\User::model()->byRunetId($runetId)->byVisible()->find($criteria);
    if ($user == null)
    {
      throw new \CHttpException(404);
    }
    
    $criteria = new \CDbCriteria();
    $criteria->with = array('Section', 'Report');
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->params = array(
      'UserId'  => $user->Id,
    );
    $sections  = array();
    foreach (\event\models\section\LinkUser::model()->findAll($criteria) as $link)
    {
      $sections[$link->Section->EventId][] = $link;
    }
    
    $participation = new \stdClass();
    $participation->Participation = array();
    $participation->Years = array();
    $participation->RoleCount = new \stdClass();
    
    foreach ($user->Participants as $participant)
    {
      $eventId = $participant->EventId;
      if (!isset($participation->Participation[$eventId]))
      {
        $participation->Participation[$eventId] = new \stdClass();
        $participation->Participation[$eventId]->Event = $participant->Event;
        $participation->Participation[$eventId]->Roles = array();
        $participation->Participation[$eventId]->HasSections = false;
        if (!in_array($participant->Event->StartYear, $participation->Years))
        {
          $participation->Years[] = $participant->Event->StartYear;
        }
      }
      
      $role = new \stdClass();
      if (!isset($sections[$eventId]))
      {
        $role->Role = $participant->Role;
        $participation->Participation[$eventId]->Roles[] = $role;
      }
      else if (!$participation->Participation[$eventId]->HasSections)
      {
        $participation->Participation[$eventId]->HasSections = true;
        foreach ($sections[$eventId] as $section)
        {
          $role->Role = $section->Role;
          $role->Report = $section->Report;
          $participation->Participation[$eventId]->Roles[] = $role;
        }
      }
    }
    
    foreach ($participation->Participation as $participant)
    {
      $roletype = \event\models\RoleType::None;
      foreach ($participant->Roles as $role)
      {
        $roletype = \event\models\RoleType::compare($roletype, $role->Role->Type);
      }
      $participation->RoleCount->{$roletype}++;
    }
    
    
    \Yii::app()->clientScript->registerPackage('runetid.charts');
    $this->bodyId = 'user-account';
    $this->setPageTitle($user->getFullName());
    $this->render('index', array(
      'user' => $user, 
      'participation' => $participation,
    ));
  }
}

?>
