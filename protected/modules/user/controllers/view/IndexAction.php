<?php
namespace user\controllers\view;

class IndexAction extends \CAction
{
  /** @var \user\models\User */
  protected $user;

  public function run($runetId)
  {
    $this->initUser($runetId);
    $this->iniPageProperties();

    $professionalInterests = [];
    foreach ($this->user->LinkProfessionalInterests as $interest) {
      $professionalInterests[] = $interest->ProfessionalInterest->Title;
    }

    $this->getController()->render('index', array(
      'user' => $this->user,
      'participation' => $this->getParticipation(),
      'professionalInterests' => $professionalInterests,
      'recommendedEvents' => $this->getRecommendedEvents(),
      'employmentHistory' => $this->getEmploymentHistory()
    ));
  }


  protected function initUser($runetId)
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
    $this->user = \user\models\User::model()->byRunetId($runetId)->byVisible()->find($criteria);
    if ($this->user == null)
      throw new \CHttpException(404);
  }

  private function getParticipation()
  {
    $criteria = new \CDbCriteria();
    $criteria->addCondition('"t"."UserId" = :UserId');
    $criteria->params = ['UserId'  => $this->user->Id];
    $criteria->with = ['Section', 'Report', 'Role'];
    $criteria->order = '"Role"."Priority" DESC';

    $linkUsers = \event\models\section\LinkUser::model()->findAll($criteria);

    $collection = new ParticipantCollection($this->user);
    foreach ($this->user->Participants as $participant)
    {
      $collection->parseParticipant($participant);
    }
    foreach ($linkUsers as $linkUser)
    {
      $collection->parseSection($linkUser);
    }
    $collection->finalCalc();
    return $collection;
  }

  /**
   *
   * @return \event\models\Event[]
   */
  private function getRecommendedEvents()
  {
    $result = array();
    if (!empty($this->user->LinkProfessionalInterests))
    {
      $professionalInterestListId = array();
      foreach ($this->user->LinkProfessionalInterests as $linkProfessionalInterest)
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

    if (sizeof($result) < \Yii::app()->params['UserViewMaxRecommendedEvents'])
    {
      $criteria = new \CDbCriteria();
      $criteria->limit = \Yii::app()->params['UserViewMaxRecommendedEvents'] - sizeof($result);
      if (!empty($result))
      {
        $excludedEventIdList = array();
        foreach ($result as $event)
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

  /**
   *
   */
  private function getEmploymentHistory()
  {
    $result = [];
    $i = 0;
    $lastCompanyName = null;
    foreach ($this->user->Employments as $employment)
    {
      if ($employment->Company->Name !== $lastCompanyName)
      {
        $i++;
      }
      $result[$i][] = $employment;
      $lastCompanyName = $employment->Company->Name;
    }
    return $result;
  }

  /**
   *
   */
  private function iniPageProperties()
  {
    $this->getController()->setPageTitle($this->user->getFullName() . ' / RUNET-ID');
    \Yii::app()->getClientScript()->registerPackage('runetid.charts');
    if (!$this->user->Settings->IndexProfile)
    {
      \Yii::app()->getClientScript()->registerMetaTag('noindex,noarchive','robots');
    }
    $description = '';

    $employment  = $this->user->getEmploymentPrimary();
    if ($employment !== null)
    {
      $description .= !empty($employment->Position) ? ($employment->Position . ' ' . \Yii::t('app','в') . ' ' . $employment->Company->Name) : (\Yii::t('app','В') . ' ' . $employment->Company->Name);
      if (!empty($employment->StartYear))
      {
        $description.=' ' . \Yii::t('app', 'c') . ' ' . $employment->StartYear . ' ' . \Yii::t('app', 'года');
      }
      $description.='.';
    }

    $interests = [];
    foreach ($this->user->LinkProfessionalInterests as $link)
    {
      $interests[] = $link->ProfessionalInterest->Title;
    }
    if (!empty($interests))
    {
      $description .= (!empty($description) ? ' ' : '').\Yii::t('app','Профессиональные интересы: ').' '.implode(', ', $interests);
    }

    \Yii::app()->getClientScript()->registerMetaTag($this->user->getFullName(), 'og:title');
    \Yii::app()->getClientScript()->registerMetaTag($this->user->getFullName(), 'title');
    \Yii::app()->getClientScript()->registerMetaTag($description, 'og:description');
    \Yii::app()->getClientScript()->registerMetaTag($description, 'description');
    \Yii::app()->getClientScript()->registerMetaTag($this->user->getUrl(), 'og:url');

    $photoUrl = 'http://' . RUNETID_HOST . $this->user->getPhoto()->getOriginal();
    \Yii::app()->getClientScript()->registerMetaTag($photoUrl, 'og:image');
    \Yii::app()->getClientScript()->registerLinkTag('image_src', null, $photoUrl);
  }
}

class ParticipantCollection
{
  /** @var ParticipantDetail[]  */
  public $participants = [];

  /** @var int[] */
  public $years = [];

  public $count = [];

  private $user;

  /**
   * @param \user\models\User $user
   */
  public function __construct($user)
  {
    $this->user = $user;
  }

  /**
   * @param \event\models\Participant $participant
   */
  public function parseParticipant($participant)
  {
    $eventId = $participant->EventId;
    if ($participant->Event == null)
      return;

    if (!isset($this->participants[$eventId]))
    {
      $this->participants[$eventId] = new ParticipantDetail();
    }
    $this->participants[$eventId]->addParticipant($participant);
    $this->years[] = $participant->Event->StartYear;
  }

  /**
   * @param \event\models\section\LinkUser $linkUser
   */
  public function parseSection($linkUser)
  {
    $eventId = $linkUser->Section->EventId;
    if (isset($this->participants[$eventId]))
    {
      $this->participants[$eventId]->addSectionLinkUser($linkUser);
    }
  }

  public function finalCalc()
  {
    foreach ($this->participants as $participant)
    {
      if (!isset($this->count[$participant->roleType]))
      {
        $this->count[$participant->roleType] = 0;
      }
      $this->count[$participant->roleType]++;
    }

    $this->years = array_unique($this->years);
    rsort($this->years, SORT_NUMERIC);
  }
}

class ParticipantDetail
{
  /** @var \event\models\Event */
  public $event;

  /** @var  \event\models\Role */
  public $role;

  /** @var RoleDetail[] */
  public $sectionRoleDetails = [];

  /** @var string */
  public $roleType = \event\models\RoleType::None;

  /**
   * @param \event\models\Participant $participant
   */
  public function addParticipant($participant)
  {
    if (empty($this->event))
    {
      $this->event = $participant->Event;
      $this->role = $participant->Role;
    }
    elseif ($participant->Role->Priority > $this->role->Priority)
    {
      $this->role = $participant->Role;
    }
    $this->roleType = \event\models\RoleType::compare($this->roleType, $this->role->Type);
  }

  /**
   * @param \event\models\section\LinkUser $linkUser
   */
  public function addSectionLinkUser($linkUser)
  {
    if (empty($this->sectionRoleDetails[$linkUser->RoleId]))
    {
      $this->sectionRoleDetails[$linkUser->RoleId] = new RoleDetail();
    }
    $this->sectionRoleDetails[$linkUser->RoleId]->addSectionUserLink($linkUser);
    $this->roleType = \event\models\RoleType::compare($this->roleType, $linkUser->Role->Type);
  }
}

class RoleDetail
{
  /** @var  \event\models\section\Role */
  public $role;

  /** @var \event\models\section\LinkUser[]  */
  public $sectionLinkUsers = [];

  /**
   * @param \event\models\section\LinkUser $linkUser
   */
  public function addSectionUserLink($linkUser)
  {
    if (empty($this->role))
    {
      $this->role = $linkUser->Role;
    }
    $this->sectionLinkUsers[] = $linkUser;
  }
}

