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
        'with' => array('Event', 'Role'),
        'order' => '"Event"."EndYear" DESC, "Event"."EndMonth" DESC'
      ),
      'Commissions' => array(
        'together' => false
      )
    );
    /** @var $user \user\models\User */
    $user = \user\models\User::model()->byRunetId($runetId)->byVisible()->find($criteria);
    if ($user == null)
    {
      throw new \CHttpException(404);
    }
    $this->setPageTitle($user->getFullName() . ' / RUNET-ID');
    
    $criteria = new \CDbCriteria();
    $criteria->with = array('Section', 'Report', 'Role');
    $criteria->condition = '"t"."UserId" = :UserId';
    $criteria->order = '"Role"."Priority" DESC';
    $criteria->params = array(
      'UserId'  => $user->Id,
    );
    $linkSections  = array();
    foreach (\event\models\section\LinkUser::model()->findAll($criteria) as $link)
    {
      $linkSections[$link->Section->EventId][] = $link;
    }
    
    $participation = new \stdClass();
    $participation->Participation = array();
    $participation->Years = array();
    $participation->RoleCount = new \stdClass();
    
    foreach ($user->Participants as $participant)
    {
      $eventId = $participant->EventId;
      
      if (isset($participation->Participation[$eventId]))
        continue;
      
      $participation->Participation[$eventId] = new \stdClass();
      $participation->Participation[$eventId]->Event = $participant->Event;
      $participation->Participation[$eventId]->Roles = array();
      $participation->Participation[$eventId]->HasSections = false;
      if (!in_array($participant->Event->StartYear, $participation->Years))
      {
        $participation->Years[] = $participant->Event->StartYear;
      }
      
      if (!isset($linkSections[$eventId]))
      {
        $role = new \stdClass();
        $role->Id    = $participant->Role->Id;
        $role->Title = $participant->Role->Title;
        $role->Type  = $participant->Role->Type;
        $participation->Participation[$eventId]->Roles[] = $role;
      }
      else
      {
        $participation->Participation[$eventId]->HasSections = true;
        foreach ($linkSections[$eventId] as $linkSection)
        {
          $role = new \stdClass();
          $role->Id    = $linkSection->Role->Id;
          $role->Title = $linkSection->Role->Title;
          $role->Type  = $linkSection->Role->Type;
          if (!isset($participation->Participation[$eventId]->Roles[$role->Id]))
          {
            $participation->Participation[$eventId]->Roles[$role->Id] = $role;
          }
          $participation->Participation[$eventId]->Roles[$role->Id]->Sections[] = $linkSection->Section;
        }
      }
    }
    
    foreach ($participation->Participation as $participant)
    {
      $roletype = \event\models\RoleType::None;
      foreach ($participant->Roles as $role)
      {
        $roletype = \event\models\RoleType::compare($roletype, $role->Type);
      }
      $participation->RoleCount->{$roletype}++;
    }
    
    if (!$user->Settings->IndexProfile)
    {
      \Yii::app()->clientScript->registerMetaTag('noindex,noarchive','robots');
    }
    
    \Yii::app()->clientScript->registerPackage('runetid.charts');
    $this->bodyId = 'user-account';
    $this->render('index', array(
      'user' => $user, 
      'participation' => $participation,
    ));
  }
}

?>
