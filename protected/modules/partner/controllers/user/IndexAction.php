<?php
namespace partner\controllers\user;

class IndexAction extends \partner\components\Action
{
  public function run()
  {
    $this->getController()->setPageTitle('Поиск участников мероприятия');
    $this->getController()->initActiveBottomMenu('index');

    $criteria = new \CDbCriteria();
    $criteria->condition = 't.EventId = :EventId AND Settings.Visible = \'1\'';
    $criteria->params = array(
      'EventId' => \Yii::app()->partner->getAccount()->EventId
    );
    $criteria->with = array(
      'User',
      'User.Employments',
      'User.Settings',
      'User.Employments.Company',
      'Role',
      'User.Emails',
      'User.Phones'
    );
    $criteria->order = 't.CreationTime DESC';
    
    $request = \Yii::app()->request;

    $page = (int) $request->getParam('page', 0);
    if ($page <= 0)
    {
      $page = 1;
    }


    $filter = $request->getParam('Filter', array());
    if (!empty($filter))
    {
      if (!empty($filter['Query']) || !empty($filter['RoleId']))
      {
        $criteria2 = new \CDbCriteria();
        if (!empty($filter['Query']))
        {
          if (strpos($filter['Query'], '@'))
          {
            $criteria2->condition = 't.Email = :Email OR Emails.Email = :Email';
            $criteria2->params['Email'] = $filter['Query'];
            $criteria2->with = array('Emails');
          }
          else
          {
            $criteria2 = \user\models\User::GetSearchCriteria($filter['Query']);
            $criteria2->with = array('Settings');
          }
        }
        
        if (!empty($filter['RoleId']))
        {
          $criteria2->addCondition('Participants.RoleId = :RoleId');
          $criteria2->params['RoleId'] = $filter['RoleId'];
        }
        
        $criteria2->with[] = 'Participants';
        $criteria2->addCondition('Participants.EventId = :EventId');
        $criteria2->params['EventId'] = $criteria->params['EventId'];
        $users = \user\models\User::model()->findAll($criteria2);
        $userIdList = array();
        if (!empty($users))
        {
          foreach ($users as $user)
          {
            $userIdList[] = $user->UserId;
          }
        }
        $criteria->addInCondition('t.UserId', $userIdList); 
      }
      
      $sort = explode('_', $filter['Sort']);
      switch($sort[0])
      { 
        case 'LastName':
          $criteria->order = 'User.LastName';
          break;
        
        case 'RocId':
          $criteria->order = 'User.RocId';
          break;
        
        case 'Role':
          $criteria->order = 'Role.Priority';
          break;
        
        case 'DateRegister':
        default:
          $criteria->order = 't.CreationTime';
          break;
      }
      $criteria->order .= $sort[1] == 'ASC' ? ' ASC' : ' DESC';
    }
   
    $criteria->group = 't.UserId';
    $count = \event\models\Participant::model()->count($criteria);
    // TODO: Проверить работу Count в мероприятиях с несколькими днями


    /** @var $event \event\models\Event */
    $event = \event\models\Event::model()->findByPk(\Yii::app()->partner->getAccount()->EventId);

    $criteria->limit  = \UserController::UsersOnPage;
    $criteria->offset = \UserController::UsersOnPage * ($page-1);

    $users = array();
    /** @var $participants \event\models\Participant[] */
    $participants = \event\models\Participant::model()->findAll($criteria);
    foreach ($participants as $participant)
    {
      $users [$participant->UserId] = array(
        'Participant' => $participant
      );
      if ( !empty ($event->Days))
      {
        $users[$participant->UserId]['DayRoles'] = \event\models\Participant::model()->byUserId($participant->UserId)->byEventId($participant->EventId)->findAll('t.DayId IS NOT NULL');
      }
    }

    $roles = \event\models\Event::model()->findByPk(\Yii::app()->partner->getAccount()->EventId)->GetUsingRoles();



    $this->getController()->render('index',
      array(
        'users' => $users,
        'roles' => $roles,
        'event' => $event,
        'filter' => $filter,
        'count' => $count,
        'page' => $page,
        'filter' => $filter
      )
    );
  }
}