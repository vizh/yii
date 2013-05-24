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
      'CommissionsActive' => array(
        'together' => false
      ),
      'LinkProfessionalInterests' => array(
        'together' => false
      ),
      'LinkProfessionalInterests.ProfessionalInterest'
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

    $professionalInterests = array();
    if (!empty($user->LinkProfessionalInterests)) {
      foreach ($user->LinkProfessionalInterests as $interest) {
        $professionalInterests[] = $interest->ProfessionalInterest->Title;
      }
    }

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
      'professionalInterests' => $professionalInterests,
      'recommendedEvents' => $this->getRecommendedEvents($user)
    ));
  }
  
  
  private function getRecommendedEvents($user)
  {
    $result = array();
    if (!empty($user->LinkProfessionalInterests))
    {
      $professionalInterestListId = array();
      foreach ($user->LinkProfessionalInterests as $linkProfessionalInterest)
      {
        $professionalInterestListId[] = $linkProfessionalInterest->ProfessionalInterestId;
      }
      $criteria = new \CDbCriteria();
      $criteria->with  = array('LinkProfessionalInterests' => array('together' => true));
      $criteria->limit = \Yii::app()->params['UserViewMaxRecommendedEvents'];
      $criteria->addInCondition('"LinkProfessionalInterests"."ProfessionalInterestId"', $professionalInterestListId);
      $events = \event\models\Event::model()
        ->byFromDate(date('Y'), date('n'), date('j'))->byVisible()->orderByDate()->findAll($criteria);
      
      $result = array_merge($result, $events);
    }
    
    if (sizeof($events) < \Yii::app()->params['UserViewMaxRecommendedEvents'])
    {
      $criteria = new \CDbCriteria();
      $criteria->limit = \Yii::app()->params['UserViewMaxRecommendedEvents'] - sizeof($events);
      if (!empty($events))
      { 
        $excludedEventIdList = array(); 
        foreach ($events as $event)
        {
          $excludedEventIdList[] = $event->Id;
        }
        $criteria->addNotInCondition('"t"."Id"', $excludedEventIdList);
      }
      $events = \event\models\Event::model()
        ->byFromDate(date('Y'), date('n'), date('j'))->byVisible()->orderByDate()->findAll($criteria);
      
      $result = array_merge($result, $events);
    }
    return $result;
  }
}

?>
